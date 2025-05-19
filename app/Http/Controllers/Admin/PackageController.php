<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('package.paket', compact('packages'));
    }

    public function create()
    {
        return view('package.create-paket');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'duration_in_days' => 'required|integer|min:1',
        ]);

        Package::create($request->all());

        return redirect()->route('packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(Package $package)
    {
        return view('package.edit-paket', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'duration_in_days' => 'required|integer|min:1',
        ]);

        $package->update($request->all());

        return redirect()->route('paket.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('paket.index')->with('success', 'Paket berhasil dihapus.');
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
