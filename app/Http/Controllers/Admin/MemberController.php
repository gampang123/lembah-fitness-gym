<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar member.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika admin, tampilkan semua member. Jika bukan admin, hanya tampilkan member yang login.
        if ($user->role_id == 1) { // Anggap role_id = 1 adalah admin
            $members = Member::with('user')->get();
        } else {
            $members = Member::with('user')->where('user_id', $user->id)->get();
        }

        return view('member.member', compact('members'));
    }

    /**
     * Menampilkan form untuk menambahkan member baru.
     */
    public function create(): View
    {
        $user = Auth::user();

        // Jika admin, tampilkan semua user. Jika bukan admin, hanya tampilkan user yang sedang login.
        if ($user->role_id == 1) {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return view('member.create-member', compact('users'));
    }

    /**
     * Menyimpan member baru ke dalam database.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Cegah user biasa memilih user lain
        if ($user->role_id != 1 && $request->user_id != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambahkan member lain.');
        }

        // Simpan data member
        $member = Member::create([
            'user_id' => $request->user_id,
            'barcode' => $request->barcode, 
            'barcode_path' => null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Generate QR Code
        $barcodeGenerator = new DNS2D();
        $barcodeImage = $barcodeGenerator->getBarcodePNG($request->barcode, "QRCODE", 10, 10);

        if (!$barcodeImage) {
            return redirect()->back()->with('error', 'Gagal membuat QR Code!');
        }

        // Simpan barcode ke storage
        $barcodePath = 'barcodes/' . $request->barcode . '.png';
        $decodedImage = base64_decode($barcodeImage);

        if (!$decodedImage) {
            return redirect()->back()->with('error', 'Gagal mengonversi QR Code ke format gambar!');
        }

        Storage::disk('public')->put($barcodePath, $decodedImage);

        // Pastikan file tersimpan
        if (!Storage::disk('public')->exists($barcodePath)) {
            return redirect()->back()->with('error', 'Gagal menyimpan QR Code ke storage!');
        }

        // Update barcode_path
        $member->barcode_path = $barcodePath;
        $member->save();

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan dengan QR Code.');
    }

    /**
     * Menampilkan form untuk mengedit member.
     */
    public function edit(Member $member)
    {
        $user = Auth::user();

        // Cegah user biasa mengedit data member lain
        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk mengedit member ini.');
        }

        // Jika admin, tampilkan semua user. Jika bukan admin, hanya tampilkan user yang login.
        if ($user->role_id == 1) {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return view('member.edit-member', compact('member', 'users'));
    }

    /**
     * Mengupdate data member.
     */
    public function update(Request $request, Member $member)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Cegah user biasa mengedit data member lain
        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui member ini.');
        }

        // Update data member
        $member->update([
            'user_id' => $request->user_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    /**
     * Menghapus member.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $member = Member::findOrFail($id);

        // Cegah user biasa menghapus data member lain
        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk menghapus member ini.');
        }

        // Hapus barcode jika ada
        if ($member->barcode_path && Storage::disk('public')->exists($member->barcode_path)) {
            Storage::disk('public')->delete($member->barcode_path);
        }

        // Hapus member dari database
        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }

    /**
     * Menampilkan kartu member untuk user yang login.
     */
    public function card()
    {
        $user = Auth::user();

        // Jika admin, tampilkan semua kartu member. Jika bukan admin, hanya tampilkan kartu miliknya sendiri.
        if ($user->role_id == 1) { // Anggap role_id = 1 adalah admin
            $members = Member::with('user')->get();
        } else {
            $members = Member::with('user')->where('user_id', $user->id)->get();
        }

        return view('member.card-member', compact('members'));
    }

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role_id != 1) {
                return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
            return $next($request);
        })->only(['edit', 'update', 'destroy']);
    }


}
