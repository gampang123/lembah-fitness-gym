@extends('layouts.app')

@section('title', 'CreatePaket')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Tambah Paket</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
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
                
                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('paket.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                
                </div>
            </div>
        </div>
    </div>

@endsection
