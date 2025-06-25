@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <div class="page-container">
        <div class="main-content">
            <div class="page-header">
                <h2 class="header-title">Tambah User</h2>
                <div class="header-sub-title">
                    <nav class="breadcrumb breadcrumb-dash">
                        <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i
                                class="anticon anticon-home m-r-5"></i>Home</a>
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
                                <label class="block">Nama <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div style="display: flex; gap: 16px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username') }}"
                                        required>
                                    @error('username')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                        required>
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div style="display: flex; gap: 16px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Phone <span class="text-danger">*</span></label>
                                    <input type="number" name="phone" class="form-control" value="{{ old('phone') }}"
                                        required>
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Umur</label>
                                    <input type="number" name="age" class="form-control" value="{{ old('age') }}">
                                    @error('age')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Jenis Kelamin</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih jenis
                                            kelamin</option>
                                        <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div style="display: flex; gap: 16px;">
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Alamat</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" style="flex: 1;">
                                    <label class="block">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" required>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="block">Role <span class="text-danger">*</span></label>
                                <select name="role_id" class="form-control" required>
                                    <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ old('role_id') == 2 ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
                        </form>


                    </div>
                </div>
            </div>
        </div>

    @endsection
