@extends('layouts.app')

@section('title', 'Paket')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Daftar Paket</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Daftar Paket</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <div>
                        <h4>Daftar Paket</h4>
                        <p>Tabel ini berisi data paket yang tersedia</p>
                    </div>
                    <a href="{{ route('packages.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add Paket
                    </a>                    
                </div>
                
                <div class="m-t-25">
                    <table id="data-table" class="table">
                        @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                @if(auth()->user()->role_id == 1)
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $package->name }}</td>
                                <td>
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if(auth()->user()->role_id == 1)
                                        <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('packages.destroy', $package->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus paket ini?')">Hapus</button>
                                        </form>
                                        @endif
                                        <a href="" class="btn btn-success btn-sm">Daftar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
