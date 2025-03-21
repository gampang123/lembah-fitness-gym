@extends('layouts.app')

@section('title', 'Member')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Data Member</h4>
            </div>
            <div class="card-body">
                <p class="mb-3">Tabel ini berisi data anggota dengan informasi barcode dan status keanggotaan.</p>

                {{-- Input Search --}}
                <div class="flex justify-between mb-4">
                    <input type="text" id="search" class="border p-2 rounded w-1/3" placeholder="Cari Nama Member...">
                    <a href="{{ route('member.create') }}" class="btn btn-primary">
                        Add Member
                    </a>
                </div>  

                {{-- Table --}}
                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered">
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
                                <td class="member-name">{{ $member->user->name }}</td>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search");
        const table = document.getElementById("data-table").getElementsByTagName("tbody")[0];

        searchInput.addEventListener("keyup", function () {
            const filter = searchInput.value.toLowerCase();
            const rows = table.getElementsByTagName("tr");

            for (let row of rows) {
                let nameCell = row.getElementsByClassName("member-name")[0];
                if (nameCell) {
                    let name = nameCell.textContent || nameCell.innerText;
                    row.style.display = name.toLowerCase().includes(filter) ? "" : "none";
                }
            }
        });
    });
</script>


@endsection
