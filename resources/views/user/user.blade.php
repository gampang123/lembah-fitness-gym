@extends('layouts.app')

@section('title', 'User')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Daftar User</h4>
            </div>
            <div class="card-body">
                <p class="mb-3">Tabel ini berisi daftar user</p>
                <div class="flex justify-between mb-4">
                    <input type="text" id="search" class="border p-2 rounded w-1/3" placeholder="Cari Nama User...">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        Add User
                    </a>
                </div>                
                <div class="table-responsive">       
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            const table = document.getElementById("data-table").getElementsByTagName("tbody")[0];
    
            searchInput.addEventListener("keyup", function () {
                const filter = searchInput.value.toLowerCase();
                const rows = table.getElementsByTagName("tr");
    
                for (let row of rows) {
                    let nameCell = row.getElementsByClassName("user-name")[0];
                    if (nameCell) {
                        let name = nameCell.textContent || nameCell.innerText;
                        row.style.display = name.toLowerCase().includes(filter) ? "" : "none";
                    }
                }
            });
        });
    </script>

@endsection
