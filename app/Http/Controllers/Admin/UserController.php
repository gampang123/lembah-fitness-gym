<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.user', compact('users'));
    }

    public function create()
    {
        return view('user.create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'age' => ['nullable', 'integer', 'min:15'],
            'gender' => ['string', 'max:255'],
            'address' => ['string', 'max:255'],
            'role_id' => 'required|integer',
        ]);

        // Simpan user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'role_id' => $request->role_id,
        ]);

        // Create member QR Code
        $barcode = 'MEMBER-' . $user->id . '-' . strtoupper(Str::random(5));

        $member = Member::create([
            'user_id' => $user->id,
            'barcode' => $barcode,
            'barcode_path' => null,
            'start_date' => null,
            'end_date' => null,
        ]);

        $barcodeGenerator = new DNS2D();
        $barcodeImage = $barcodeGenerator->getBarcodePNG($barcode, "QRCODE", 10, 10);

        if (!$barcodeImage) {
            return redirect()->route('user.index')->with('error', 'Gagal membuat QR Code.');
        }

        $barcodePath = 'barcodes/' . $barcode . '.png';
        $decodedImage = base64_decode($barcodeImage);
        Storage::disk('public')->put($barcodePath, $decodedImage);

        $member->barcode_path = $barcodePath;
        $member->save();

        return redirect()->route('user.index')->with('success', 'User & Member berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:15',
            'gender' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'role_id' => 'required|integer',
        ]);

        // dd($request);

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'age' => $request->age,
            'gender' => $request->gender,
            'address' => $request->address,
            'role_id' => $request->role_id,
        ]);

        // dd($user);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
