@extends('layouts.app')

@section('title', 'CreatePaket')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Tambah Paket</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Tambah paket</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Tambah paket</h4>
                <p>Form tambah paket</p>
                <div class="m-t-25">
                    <form action="{{ route('packages.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Paket</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="duration_in_days" class="form-label">Jumlah Hari</label>
                            <input type="number" name="duration_in_days" class="form-control" required>
                        </div>
                
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('paket.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
