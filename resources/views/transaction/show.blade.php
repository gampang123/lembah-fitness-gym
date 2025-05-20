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
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->member->user->name }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Kontak</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->member->user->email }} | {{ $transaction->member->user->phone}}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Paket</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->package->name }} ({{ $transaction->package->duration_in_days }} hari)
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Metode Bayar</label>
                        <div class="col-sm-9 col-form-label">
                            {{ ucfirst($transaction->payment_method) }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9 col-form-label">
                            {{ ucfirst($transaction->status) }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Dibuat Oleh</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->creator->name ?? '-' }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Dibuat Pada</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->created_at->format('d-m-Y H:i') }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Diupdate Pada</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->updated_at->format('d-m-Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($transaction->proofOfPayment)
        <div class="card">
            <div class="card-body">
                <h4>Bukti Pembayaran</h4>
                <div class="m-t-25">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Nama File</label>
                        <div class="col-sm-9 col-form-label">
                            {{ $transaction->proofOfPayment->src_name }}
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Preview</label>
                        <div class="col-sm-9">
                            @php
                                $ext = strtolower(pathinfo($transaction->proofOfPayment->src_path, PATHINFO_EXTENSION));
                            @endphp
                            @if(in_array($ext, ['jpg','jpeg','png']))
                                <img src="{{ asset('storage/' . $transaction->proofOfPayment->src_path) }}" 
                                     alt="Proof" class="img-fluid">
                            @else
                                <a href="{{ asset('storage/' . $transaction->proofOfPayment->src_path) }}"
                                   class="btn btn-outline-primary" target="_blank">
                                    <i class="fas fa-file-pdf"></i> Lihat PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('transaction.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if(auth()->user()->role_id === 1 || $transaction->created_by === auth()->id())
                @if($transaction->status === 'pending')
                    <form action="{{ route('transaction.approve', $transaction->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui transaksi ini?')">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </form>
                    <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Batalkan transaksi ini?')">
                            <i class="fas fa-times"></i> Batal
                        </button>
                    </form>
                @endif
                <form action="{{ route('transaction.destroy', $transaction->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini beserta bukti pembayaran?')">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
