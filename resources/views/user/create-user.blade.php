@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Tambah User</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Tambah User</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Add User</h4>
                <p>Form tambah data User</p>
                <div class="m-t-25">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Role</label>
                            <select name="role_id" class="form-control" required>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
    
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
