@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Tambah User</h4>
            </div>
            <div class="card-body">               
                <div class="table-responsive">       
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
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
