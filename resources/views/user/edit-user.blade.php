@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="page-container">
        <div class="main-content">
            <div class="page-header">
                <h2 class="header-title">Edit User</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i
                                class="anticon anticon-home m-r-5"></i>Home</a>
                        <span class="breadcrumb-item active">Edit User</span>
                    </nav>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4>Edit User</h4>
                    <p>Form edit data User</p>
                    <div class="m-t-25">
                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="block">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}"
                                    required>
                            </div>

                            <div style="display: flex; gap: 16px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ $user->username }}"
                                        required>
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}"
                                        required>
                                </div>
                            </div>

                            <div style="display: flex; gap: 16px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Phone</label>
                                    <input type="number" name="phone" class="form-control" value="{{ $user->phone }}"
                                        required>
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Umur</label>
                                    <input type="number" name="age" class="form-control" value="{{ $user->age }}">
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Jenis Kelamin</label>
                                    <select name="gender" class="form-control">
                                        <option value="" disabled>Pilih jenis kelamin</option>
                                        <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div style="display: flex; gap: 16px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Alamat</label>
                                    <input type="text" name="address" class="form-control" value="{{ $user->address }}">
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Role</label>
                                    <select name="role_id" class="form-control" required>
                                        <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
                                        <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    @endsection
