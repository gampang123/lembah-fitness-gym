@extends('layouts.app')

@section('title', 'Data Aktivitas Member')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Data Aktivitas {{ $member->user->name }}</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Daftar Aktivitas {{ $member->user->name }}</span>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h4 class="mb-2">Data Aktivitas {{ $member->user->name }}</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('generic.export', ['type' => 'excel', 'model' => 'Presence']) }}" class="btn btn-success">Export Excel</a>
                        <a href="{{ route('generic.export', ['type' => 'pdf', 'model' => 'Presence']) }}" class="btn btn-danger">Export PDF</a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="data-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Member</th>
                                <th>Tanggal</th>
                                <th>Scan In</th>
                                <th>Scan Out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activity as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $activity->member->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->scan_in_at)->format('Y-m-d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->scan_in_at)->format('H:i:s') }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->scan_out_at)->format('H:i:s') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
