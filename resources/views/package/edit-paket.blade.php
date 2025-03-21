@extends('layouts.app')

@section('title', 'EditPaket')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Edit Paket</h4>
            </div>
            <div class="card-body">
                <p class="mb-3">Tabel ini berisi data anggota dengan informasi barcode dan status keanggotaan.</p>
                <div class="table-responsive">
                    <form action="{{ route('packages.update', $package->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Paket</label>
                            <input type="text" name="name" class="form-control" value="{{ $package->name }}" required>
                        </div>
                
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control" value="{{ $package->price }}" required>
                        </div>
                
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('packages.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
