@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Tambah Transaksi</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Tambah Transaksi</span>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Form Transaksi</h4>
                <div class="m-t-25">
                    <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Pilih Member</label>
                            <div class="col-sm-10">
                                <select name="member_id" class="form-control">
                                    <option value="">-- Pilih Member --</option>
                                    @foreach ($members as $member)
                                        <option value="{{ $member->id }}">{{ $member->user->name }}</option>
                                    @endforeach
                                </select>
                                @error('member_id')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Pilih Paket</label>
                            <div class="col-sm-10">
                                <select name="package_id" class="form-control">
                                    <option value="">-- Pilih Paket --</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }} - Rp{{ number_format($package->price) }}</option>
                                    @endforeach
                                </select>
                                @error('package_id')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Metode Pembayaran</label>
                            <div class="col-sm-10">
                                <select name="payment_method" class="form-control">
                                    <option value="">-- Pilih Metode --</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Transfer Bank</option>
                                </select>
                                @error('payment_method')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Bukti Bayar</label>
                            <div class="col-sm-10">
                                <input type="file" name="proof_file" class="form-control-file">
                                <small class="form-text text-muted">Opsional. Maks 2MB. Format: jpg, jpeg, png, pdf.</small>
                                @error('proof_file')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10 offset-sm-2">
                                <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
