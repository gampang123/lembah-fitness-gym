@extends('layouts.app')

@section('title', 'Paket')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Daftar Paket</h4>
            </div>
            <div class="card-body">
                <p class="mb-3">Tabel ini berisi daftar paket yang tersedia</p>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('paket.create') }}" class="btn btn-primary">
                        Add Paket
                    </a>
                </div>                
                <div class="table-responsive">       
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packages as $package)
                                <tr>
                                    <td>{{ $package->name }}</td>
                                    <td>Rp {{ number_format($package->price, 0, ',', '.') }}</td>
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
