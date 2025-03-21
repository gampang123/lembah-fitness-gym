@extends('layouts.app')

@section('title', 'CreateMember')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Add Data Member</h4>
            </div>
            <div class="card-body">
                <p class="mb-3">Tabel ini Untuk menambah data anggota dengan informasi barcode dan status keanggotaan.</p>
                <div class="table-responsive">
                    <form action="{{ route('member.store') }}" method="POST">
                        @csrf
                
                        <!-- Pilih User -->
                        <div class="mb-4">
                            <label for="user_id" class="block text-gray-700 font-semibold mb-2">Pilih User</label>
                            <select name="user_id" id="user_id" class="w-96 px-4 py-2 border rounded-lg ml-4">
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <!-- Barcode (Otomatis dari ID) -->
                        <div class="mb-4">
                            <label for="barcode" class="block text-gray-700 font-semibold mb-2">Barcode</label>
                            <input type="text" id="barcode" name="barcode" class="w-96 px-4 py-2 border rounded-lg ml-4" readonly>
                            <p class="text-gray-500 text-sm mt-1">Barcode akan otomatis dibuat dari ID Member.</p>
                        </div>
                
                        <!-- Tanggal Mulai -->
                        <div class="mb-4">
                            <label for="start_date" class="block text-gray-700 font-semibold mb-2">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="w-96 px-4 py-2 border rounded-lg focus:ring-2 ml-4">
                            @error('start_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <!-- Tanggal Berakhir -->
                        <div class="mb-4">
                            <label for="end_date" class="block text-gray-700 font-semibold mb-2">Tanggal Berakhir</label>
                            <input type="date" id="end_date" name="end_date" class="w-96 px-4 py-2 border rounded-lg ml-4">
                            @error('end_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                
                        <!-- Tombol Submit -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('member.index') }}" class="text-blue-500 hover:underline">Kembali</a>
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
                document.getElementById('barcode').value = "MBR" + userId.padStart(5, '0');
            } else {
                document.getElementById('barcode').value = "";
            }
        });
    </script>


@endsection
