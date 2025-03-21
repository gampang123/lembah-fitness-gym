@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Edit User</h4>
            </div>
            <div class="card-body">               
                <div class="table-responsive">       
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
    
                        <div class="mb-3">
                            <label class="block">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Username</label>
                            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
    
                        <div class="mb-3">
                            <label class="block">Role</label>
                            <select name="role_id" class="form-control" required>
                                <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
    
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
