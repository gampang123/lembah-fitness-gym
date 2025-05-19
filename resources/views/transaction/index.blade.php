@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Daftar Transaksi</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Daftar Transaksi</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <div>
                        <h4>Daftar Transaksi</h4>
                        <p>Tabel ini berisi seluruh data transaksi</p>
                    </div>
                    <a href="{{ route('transaction.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add Transaksi
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
                                <th>Nama Member</th>
                                <th>Nama Paket</th>
                                <th>Harga</th>
                                <th>Metode Pembayaran</th>
                                <th>Status</th>
                                @if(auth()->user()->role_id == 1)
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>                        
                        <tbody>
                            @foreach ($transaction as $trx)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trx->member->user->name }}</td>
                                <td>{{ $trx->package->name }}</td>
                                <td>Rp {{ number_format($trx->package->price, 0, ',', '.') }}</td>
                                <td>{{ $trx->payment_method }}</td>
                                <td>{{ $trx->status }}</td>
                                @if(auth()->user()->role_id == 1)
                                <td>
                                    <a href="{{ route('transaction.show', $trx->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <form action="{{ route('transaction.destroy', $trx->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini?')">Hapus</button>
                                    </form>
                                    @if ($trx->status == 'pending')
                                        {{-- tombol Approve --}}
                                        <form action="{{ route('transaction.approve', $trx->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Setujui transaksi ini?')">
                                                Setujui
                                            </button>
                                        </form>

                                        {{-- tombol Cancel --}}
                                        <form action="{{ route('transaction.cancel', $trx->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm"
                                                onclick="return confirm('Batalkan transaksi ini?')">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection