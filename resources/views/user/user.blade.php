@extends('layouts.app')

@section('title', 'User')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Data User</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Data User</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <div>
                        <h4>Data User</h4>
                        <p>Tabel ini berisi data user yang terdaftar</p>
                    </div>
                    <a href="{{ route('user.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add User
                    </a>
                </div>
                <div class="m-t-25">
                    <table id="data-table" class="table table-bordered w-full">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th class="hidden">ID</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="hidden">{{ $user->id }}</td>
                                <td class="user-name">{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->role_id == 1 ? 'Admin' : 'User' }}</td>
                                <td>
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning"><i class="anticon anticon-edit"></i></a>

                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus user ini?')"><i class="anticon anticon-delete"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
