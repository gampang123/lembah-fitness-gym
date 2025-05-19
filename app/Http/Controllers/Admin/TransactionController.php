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
            'payment_method'  => 'required|in:cash,bank_transfer',
            'proof_file'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $proof = null;
            if ($request->hasFile('proof_file')) {
                $file = $request->file('proof_file');
                $path = $file->store('proof_of_payments', 'public');
                $proof = ProofOfPayment::create([
                    'src_name' => $file->getClientOriginalName(),
                    'src_path' => $path,
                ]);
            }

            $transaction = Transaction::create([
                'member_id'           => $request->member_id,
                'package_id'          => $request->package_id,
                'proof_of_payment_id' => $proof?->id,
                'payment_method'      => $request->payment_method,
                'status'              => 'pending',
                'created_by'          => auth()->id(), 
            ]);

            // If the user is admin, approve the transaction immediately
            if (auth()->user()->role_id === 1) {
                $this->approveLogic($transaction);
                $message = 'Transaksi berhasil dan langsung disetujui oleh admin';
            } else {
                $message = 'Transaksi berhasil, menunggu approval';
            }

            DB::commit();
            return redirect()->route('transaction.index')
                            ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
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

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transaction.index')->with('success', 'Transaksi dihapus');
    }

    public function show($id)
    {
        $transaction = Transaction::with(['member.user', 'package', 'proofOfPayment'])->findOrFail($id);
        return view('transaction.show', compact('transaction'));
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 1) {
                return redirect()->route('transaction.index')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
            return $next($request);
        })->only(['show', 'edit', 'update']);
    }
}
