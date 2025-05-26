<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Package;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\MidtransService;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;


class PackageMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user memiliki member
        if (!$user->member) {
            // Jika tidak ada member, bisa lempar ke halaman lain atau kirim kosong
            $activeMemberships = collect(); // collection kosong
        } else {
            $activeMemberships = Transaction::with(['package', 'member'])
            ->where('member_id', $user->member->id)
            ->where('status', 'paid')
            ->whereHas('member', function ($query) {
                $query->whereNotNull('end_date');
            })
            ->get();
        }

        return view('user-dashboard.membership.index', compact('activeMemberships'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (!$request->package_id) {
        Alert::warning('Perhatian', 'Pilih paket terlebih dahulu');
        return redirect()->route('membership.list');
        }

        $package = Package::find($request->package_id);

        if (!$package) {
            Alert::warning('Perhatian', 'Paket tidak ditemukan');
            return redirect()->route('membership.list');
        }

        return view('user-dashboard.membership.register-member', [
            'package' => $package
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list()
    {
        $packages = Package::all();

        return view('user-dashboard.membership.list-package-member', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
        ]);

        $user = Auth::user();

        if (!$user->member) {
            Alert::error('Gagal', 'Akun Anda belum memiliki data member.');
            return back()->withInput();
        }

        DB::beginTransaction();
        try {
            $package = Package::findOrFail($request->package_id);
            $member = $user->member;

            $midtransOrderId = 'ORDER-' . strtoupper(Str::random(10));
            $midtrans = new MidtransService();
            $midtransSnapToken = $midtrans->createTransaction($midtransOrderId, $package->price, [
                'first_name' => $user->name,
                'email' => $user->email,
            ]);

            $transaction = Transaction::create([
                'created_by'          => $user->id,
                'member_id'           => $member->id,
                'package_id'          => $package->id,
                'payment_method'      => 'online_payment',
                'status'              => 'pending',
                'midtrans_order_id'   => $midtransOrderId,
                'midtrans_snap_token' => $midtransSnapToken,
            ]);

            DB::commit();

            return $request->ajax()
                ? response()->json([
                    'success' => true,
                    'message' => 'Silahkan selesaikan pembayaran via Midtrans di menu transaksi untuk mengaktifkan membership.',
                    'transaction' => $transaction,
                    'snap_token' => $midtransSnapToken,
                ])
                : redirect()->route('membership.index');

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
