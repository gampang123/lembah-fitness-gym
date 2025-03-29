@extends('layouts.app')

@section('title', 'CreateMember')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Tambah Member</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Tambah Member</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Form Tambah Member</h4>
                <div class="m-t-25">
                    <form id="form-validation" action="{{ route('member.store') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Pilih User</label>
                            <select name="user_id" id="user_id" class="form-control w-96 px-4 py-2 border rounded-lg ml-4"name="inputRequired">
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Barcode</label>
                            <input type="text" id="barcode" name="barcode" class="w-96 px-4 py-2 border rounded-lg ml-4" readonly>
                            <p class="text-gray-500 text-sm mt-1">Barcode akan otomatis dibuat dari ID Member.</p>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="w-96 px-4 py-2 border rounded-lg focus:ring-2 ml-4">
                            @error('start_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label control-label">Tanggal Barakhir</label>
                            <input type="date" id="end_date" name="end_date" class="w-96 px-4 py-2 border rounded-lg ml-4">
                            @error('end_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                Tambah Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            let userId = this.value;
            if (userId) {
                document.getElementById('barcode').value = "LF" + userId.padStart(5, '0');
            } else {
                document.getElementById('barcode').value = "";
            }
        });
    </script>

@endsection
