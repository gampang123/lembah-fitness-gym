@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Detail Transaksi #{{ $transaction->id }}</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item">
                        <i class="anticon anticon-home m-r-5"></i>Home
                    </a>
                    <a href="{{ route('transaction.index') }}" class="breadcrumb-item">Transaksi</a>
                    <span class="breadcrumb-item active">Detail</span>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Informasi Transaksi</h4>
                <div class="m-t-25">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Member</label>
                        <div class="col-sm-9 col-form-label">{{ $transaction->member->user->name }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-9 col-form-label">{{ $transaction->member->user->phone }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9 col-form-label">{{ $transaction->member->user->email }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Paket</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->package->name }} ({{ $transaction->package->duration_in_days }} hari)
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Metode Bayar</label>
                        <div class="col-sm-9 col-form-label">{{ ucfirst($transaction->payment_method) }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9 col-form-label">{{ ucfirst($transaction->status) }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Dibuat Oleh</label>
                        <div class="col-sm-9 col-form-label">{{ $transaction->creator->name ?? '-' }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9 col-form-label">{{ $transaction->created_at->format('d-m-Y H:i') }}</div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Diupdate Pada</label>
                        <div class="col-sm-9 col-form-label">{{ $transaction->updated_at->format('d-m-Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('transaction.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            @if(auth()->user()->role_id === 1 || $transaction->created_by === auth()->id())
                <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus transaksi ini?')">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection