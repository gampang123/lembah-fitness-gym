<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Package;
use App\Models\ProofOfPayment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\MidtransService;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::with(['member.user', 'package', 'proofOfPayment'])->orderby('created_at', 'desc')->get();
        return view('transaction.index', compact('transaction'));
    }

    public function create()
    {
        $members = Member::with('user')->get();
        $packages = Package::all();
        return view('transaction.create', compact('members', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id'       => 'required|exists:members,id',
            'package_id'      => 'required|exists:packages,id',
            'payment_method'  => 'required|in:cash,online_payment',
        ]);

        DB::beginTransaction();
        try {

            $package = Package::findOrFail($request->package_id);
            $member = Member::with('user')->findOrFail($request->member_id);
            $orderId = 'ORDER-' . strtoupper(Str::random(10));

            // Midtrans Snap Token
            $snapToken = null;
            if ($request->payment_method === 'bank_transfer') {
                $midtrans = new \App\Services\MidtransService();
                $snapToken = $midtrans->createTransaction($orderId, $package->price, [
                    'first_name' => $member->user->name,
                    'email' => $member->user->email,
                ]);
            }

            $transaction = Transaction::create([
                'created_by'          => Auth::id(),
                'member_id'           => $request->member_id,
                'package_id'          => $request->package_id,
                'payment_method'      => $request->payment_method,
                'status'              => $request->payment_method === 'cash' ? 'approved' : 'pending',
                'order_id'            => $orderId, // Unique order ID
                'snap_token'          => $snapToken,
            ]);

            if ($request->payment_method === 'cash') {
                $this->approveLogic($transaction);
                $message = 'Transaksi berhasil dan disetujui.';
            } else {
                $message = 'Transaksi berhasil. Silakan selesaikan pembayaran via Midtrans.';
            }

            DB::commit();

            // ✅ Return JSON if AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success'      => true,
                    'message'      => $message,
                    'transaction'  => $transaction,
                    'snap_token'   => $snapToken,
                ]);
            }

            return redirect()->route('transaction.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat transaksi',
                    'error'   => $e->getMessage(),
                ], 500);
            }

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function handleCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signatureKey = hash('sha512',
            $request->input('order_id') .
            $request->input('status_code') .
            $request->input('gross_amount') .
            $serverKey
        );

        if ($signatureKey !== $request->input('signature_key')) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::where('order_id', $request->input('order_id'))->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        if ($request->input('transaction_status') === 'settlement') {
            $this->approveLogic($transaction);
        }

        return response()->json(['message' => 'Callback processed']);
    }

    protected function approveLogic(Transaction $transaction)
    {
        $member  = $transaction->member;
        $package = $transaction->package;

        // Update status
        $transaction->update(['status' => 'approved']);
        $oldStatus = $member->status;
        $member->update(['status' => 'active']);

        // Hitung tanggal
        $now        = Carbon::now();
        $currentEnd = $member->end_date ? Carbon::parse($member->end_date) : null;
        $baseStart  = ($currentEnd && $currentEnd->gt($now)) ? $currentEnd : $now;
        $newEnd     = $baseStart->copy()->addDays($package->duration_in_days);

        $data = ['end_date' => $newEnd];
        if (!$member->start_date || $oldStatus === 'expired') {
            $data['start_date'] = $baseStart;
        }

        $member->update($data);
    }

    // endpoint approve() tetap bisa dipanggil terpisah untuk user:
    public function approve($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->approveLogic($transaction);
        return redirect()->back()->with('success', 'Transaksi disetujui');
    }

    public function cancel($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'cancel']);
        return redirect()->back()->with('success', 'Transaksi dibatalkan');
    }

    public function show($id)
    {
        $user = Auth::user();

        // Eager‐load relasi yang dibutuhkan
        $transaction = Transaction::with([
            'member.user',
            'package',
            'proofOfPayment',
            'creator',          // pastikan relasi creator() ada di model
        ])->findOrFail($id);

        // Hanya ijinkan jika user adalah admin ATAU creator transaksi
        if ($user->role_id === 1 || $transaction->created_by === $user->id) {
            return view('transaction.show', compact('transaction'));
        }

        return redirect()
            ->route('transaction.index')
            ->with('error', 'Anda tidak memiliki izin untuk melihat transaksi ini.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $transaction = Transaction::with('proofOfPayment')->findOrFail($id);

        // Hanya admin atau creator yang boleh hapus
        if ($user->role_id !== 1 && $transaction->created_by !== $user->id) {
            return redirect()
                ->route('transaction.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus transaksi ini.');
        }

        DB::beginTransaction();
        try {
            // Hapus file bukti pembayaran jika ada
            if ($transaction->proofOfPayment 
                && Storage::disk('public')->exists($transaction->proofOfPayment->src_path)
            ) {
                Storage::disk('public')->delete($transaction->proofOfPayment->src_path);
            }

            // Hapus record proof
            if ($transaction->proofOfPayment) {
                $transaction->proofOfPayment->delete();
            }

            // Hapus transaksi
            $transaction->delete();

            DB::commit();
            return redirect()
                ->route('transaction.index')
                ->with('success', 'Transaksi dan bukti pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Gagal menghapus transaksi: ' . $e->getMessage(),
            ]);
        }
    }
}