@extends('layouts.app')

@section('title', 'EditMember')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Edit Data Member</h4>
            </div>
            <div class="card-body">
                <p class="mb-3">Tabel ini Untuk edit data anggota dengan informasi barcode dan status keanggotaan.</p>
                <div class="table-responsive">
                    <form action="{{ route('member.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Pilih User -->
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
                    
                        <!-- Barcode (Tidak Bisa Diubah) -->
                        <div class="mb-4">
                            <label for="barcode" class="block text-gray-700 font-semibold mb-2">Barcode</label>
                            <input type="text" id="barcode" name="barcode" class="w-96 px-4 py-2 border rounded-lg ml-4 bg-gray-200" 
                                value="{{ old('barcode', $member->barcode) }}" readonly>
                            <p class="text-gray-500 text-sm mt-1">Barcode tidak dapat diubah.</p>
                        </div>
                    
                        <!-- Tanggal Mulai -->
                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 font-semibold mb-2">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="w-96 px-4 py-2 border rounded-lg ml-4"
                                value="{{ old('start_date', $member->start_date) }}">
                            @error('start_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <!-- Tanggal Berakhir -->
                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 font-semibold mb-2">Tanggal Berakhir</label>
                            <input type="date" id="end_date" name="end_date" class="w-96 px-4 py-2 border rounded-lg ml-4"
                                value="{{ old('end_date', $member->end_date) }}">
                            @error('end_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <!-- Tombol Submit -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('member.index') }}" class="text-blue-500 hover:underline">Kembali</a>
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
