@extends('layouts.app')

@section('title', 'EditPaket')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Edit Paket</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Edit paket</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Edit paket</h4>
                <p>Form edit paket</p>
                <div class="m-t-25">
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
