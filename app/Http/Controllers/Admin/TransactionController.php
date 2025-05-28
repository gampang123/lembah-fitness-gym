<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Package;
use App\Models\Transaction;
use App\Services\MembershipActivationService;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::with(['member.user', 'package'])->orderBy('created_at', 'desc')->get();
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
            $midtransOrderId = null;

            // Midtrans Snap Token
            // $midtransSnapToken = null;
            $status = 'pending';
            $midtransRedirectUrl = null;

            if ($request->payment_method === 'online_payment') {
                $midtransOrderId = 'ORDER-' . strtoupper(Str::random(10));
                $midtrans = new MidtransService();

                // $midtransSnapToken = $midtrans->createTransaction($midtransOrderId, $package->price, [
                //     'first_name' => $member->user->name,
                //     'email' => $member->user->email,
                // ]);
                $response = $midtrans->createRedirectTransaction($midtransOrderId, $package->price, [
                    'first_name' => $member->user->name,
                    'email' => $member->user->email,
                ]);

                $midtransRedirectUrl = $response->redirect_url ?? null;
                if (!$midtransRedirectUrl) {
                    throw new \Exception('Gagal mendapatkan redirect_url dari Midtrans.');
                }
            } else {
                $status = 'paid';
            }

            $transaction = Transaction::create([
                'created_by'          => Auth::id(),
                'member_id'           => $request->member_id,
                'package_id'          => $request->package_id,
                'payment_method'      => $request->payment_method,
                'status'              => $status,
                'midtrans_order_id'   => $midtransOrderId,
                // 'midtrans_snap_token' => $midtransSnapToken,
                'midtrans_redirect_url' => $midtransRedirectUrl,
            ]);

            if ($status === 'paid') {
                (new MembershipActivationService())->approve($transaction);
            }

            DB::commit();

            $message = $status === 'paid'
                ? 'Transaksi berhasil (cash).'
                : 'Silahkan selesaikan pembayaran via Midtrans untuk mengaktifkan membership.';

            if ($status === 'paid') {
                Alert::success('Berhasil', $message);
            } elseif ($status === 'pending') {
                Alert::warning('Perhatian', $message);
            } else {
                Alert::warning('Perhatian', 'Status transaksi: ' . ucfirst($status));
            }

            return $request->ajax()
                ? response()->json([
                    'success' => true,
                    'message' => $message,
                    'transaction' => $transaction,
                    // 'snap_token' => $midtransSnapToken,
                    'redirect_url' => $midtransRedirectUrl,
                ])
                : redirect()->route('transaction.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Gagal', 'Gagal membuat transaksi: ' . $e->getMessage());
            return $request->ajax()
                ? response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat transaksi',
                    'error' => $e->getMessage(),
                ], 500)
                : back();
        }
    }

    public function testSignature(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $signatureKey = hash('sha512',
            $request->input('order_id') .
            $request->input('status_code') .
            $request->input('gross_amount') .
            $serverKey
        );

        return response()->json([
            'calculated_signature_key' => $signatureKey
        ]);
    }


    public function show($id)
    {
        $user = Auth::user();
        $transaction = Transaction::with([
            'member.user',
            'package',
            'creator',
        ])->findOrFail($id);

        if ($user->role_id === 1 || $transaction->created_by === $user->id) {
            return view('transaction.show', compact('transaction'));
        }

        Alert::warning('Peringatan', 'Anda tidak memiliki izin untuk melihat transaksi ini.');
        return redirect()->route('transaction.index');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $transaction = Transaction::findOrFail($id);

        if ($user->role_id !== 1 && $transaction->created_by !== $user->id) {
            Alert::warning('Peringatan', 'Anda tidak memiliki izin untuk menghapus transaksi ini.');
            return redirect()->route('transaction.index');
        }

        try {
            $transaction->delete();
            Alert::success('Berhasil', 'Transaksi berhasil dihapus.');
            return redirect()->route('transaction.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Gagal menghapus transaksi: ' . $e->getMessage());

            return back();
        }
    }
}
