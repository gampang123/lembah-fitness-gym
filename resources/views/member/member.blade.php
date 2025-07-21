@extends('layouts.app')

@section('title', 'Member')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Data Member</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Data Member</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="flex justify-between items-center">
                    <div>
                        <h4>Data Member</h4>
                        <p>Tabel ini berisi data member yang terdaftar</p>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('member.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Aktivasi Member
                        </a>
                        <button class="btn btn-success" >Export Excel</button>
                        <button class="btn btn-danger" id="ExportPdf" onclick="ExportPdf()">Export PDF</button>
                    </div>
                </div>
                <div class="m-t-25">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Barcode</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Status</th>
                                @if(auth()->user()->role_id == 1)
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->user->name }}</td>
                                <td>
                                    @if($member->barcode_path)
                                    <img src="{{ asset('storage/' . $member->barcode_path) }}" alt="Barcode" width="50" onerror="this.onerror=null; this.src='/fallback-image.png'">
                                    @else
                                    <span class="text-danger">Barcode tidak tersedia</span>
                                    @endif
                                </td>
                                <td>{{ $member->start_date }}</td>
                                <td>{{ $member->end_date }}</td>
                                <td>
                                    <span class="badge {{ now() > $member->end_date ? 'badge-danger' : 'badge-success' }}">
                                        {{ now() > $member->end_date ? 'Tidak Aktif' : 'Aktif' }}
                                    </span>
                                </td>
                                @if(auth()->user()->role_id == 1)
                                <td>
                                    <a href="{{ route('member.edit', $member->id) }}" class="btn btn-warning btn-sm">
                                        <i class="anticon anticon-edit"></i>
                                    </a>
                                    <form action="{{ route('member.destroy', $member->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="anticon anticon-delete"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@endsection
