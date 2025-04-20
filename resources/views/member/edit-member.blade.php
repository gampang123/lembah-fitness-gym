@extends('layouts.app')

@section('title', 'EditMember')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Edit Member</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Edit Member</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>Edit Member</h4>
                <p>Form edit data member</p>
                <div class="m-t-25">
                    <form action="{{ route('member.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 font-semibold mb-2">Pilih User</label>
                            <select name="user_id" id="user_id" class="w-96 px-4 py-2 border rounded-lg ml-4">
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $member->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="barcode" class="block text-gray-700 font-semibold mb-2">Barcode</label>
                            <input type="text" id="barcode" name="barcode" class="w-96 px-4 py-2 border rounded-lg ml-4 bg-gray-200" 
                                value="{{ old('barcode', $member->barcode) }}" readonly>
                            <p class="text-gray-500 text-sm mt-1">Barcode tidak dapat diubah.</p>
                        </div>
                    
                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 font-semibold mb-2">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="w-96 px-4 py-2 border rounded-lg ml-4"
                                value="{{ old('start_date', $member->start_date) }}">
                            @error('start_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 font-semibold mb-2">Tanggal Berakhir</label>
                            <input type="date" id="end_date" name="end_date" class="w-96 px-4 py-2 border rounded-lg ml-4"
                                value="{{ old('end_date', $member->end_date) }}">
                            @error('end_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <div class="flex justify-between items-center">
                            <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                Update Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
