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

        if ($user->role_id == 1) {
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

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        if ($user->role_id != 1 && $request->user_id != $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menambahkan member lain.');
        }

        $existingMember = Member::where('user_id', $request->user_id)->first();
        if ($existingMember) {
            return redirect()->route('member.index')->with('info', 'User ini sudah terdaftar sebagai member.');
        }

        $member = Member::create([
            'user_id' => $request->user_id,
            'barcode' => $request->barcode,
            'barcode_path' => null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        $barcodeGenerator = new DNS2D();
        $barcodeImage = $barcodeGenerator->getBarcodePNG($request->barcode, "QRCODE", 10, 10);

        if (!$barcodeImage) {
            return redirect()->back()->with('error', 'Gagal membuat QR Code!');
        }

        $barcodePath = 'barcodes/' . $request->barcode . '.png';
        $decodedImage = base64_decode($barcodeImage);

        if (!$decodedImage) {
            return redirect()->back()->with('error', 'Gagal mengonversi QR Code ke format gambar!');
        }

        Storage::disk('public')->put($barcodePath, $decodedImage);

        if (!Storage::disk('public')->exists($barcodePath)) {
            return redirect()->back()->with('error', 'Gagal menyimpan QR Code ke storage!');
        }

        $member->barcode_path = $barcodePath;
        $member->save();

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan dengan QR Code.');
    }


    /**
     * edit member
     */
    public function edit(Member $member)
    {
        $user = Auth::user();

        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk mengedit member ini.');
        }

        if ($user->role_id == 1) {
            $users = User::all();
        } else {
            $users = User::where('id', $user->id)->get();
        }

        return view('member.edit-member', compact('member', 'users'));
    }

    /**
     * Mengupdate  member.
     */
    public function update(Request $request, Member $member)
    {
        $user = Auth::user();

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk memperbarui member ini.');
        }

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

        if ($user->role_id != 1 && $member->user_id != $user->id) {
            return redirect()->route('member.index')->with('error', 'Anda tidak memiliki izin untuk menghapus member ini.');
        }

        if ($member->barcode_path && Storage::disk('public')->exists($member->barcode_path)) {
            Storage::disk('public')->delete($member->barcode_path);
        }

        $member->delete();

        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }

    /**
     * kartu member
     */
    public function card()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $members = Member::with('user')->get();
            return view('member.card-member', compact('members'));
        } else {
            $member = Member::with('user')->where('user_id', $user->id)->first();
            return view('member.card-member', compact('member'));
        }
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
