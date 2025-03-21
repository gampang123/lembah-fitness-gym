@extends('layouts.app')

@section('title', 'Kartu Member')

@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4 class="mt-2 font-bold text-xl">Kartu Anggota</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="flex justify-between mb-4">
                        <input type="text" id="search" placeholder="Cari member..." 
                            class="border p-2 rounded w-1/3" onkeyup="filterCards()">
                        
                        <select id="sort" onchange="sortCards()" class="border p-2 rounded">
                            <option value="asc">Sort by Name (A-Z)</option>
                            <option value="desc">Sort by Name (Z-A)</option>
                        </select>
                    </div>

                    <div id="member-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($members as $member)
                        <div id="card-{{ $member->id }}" class="relative w-[213px] h-[338px] bg-cover bg-center mx-auto flex flex-col justify-between"
                            style="background-image: url('{{ asset('asset/kartu.png') }}');">
                            
                            <div class="absolute inset-0 flex flex-col justify-center items-center text-white">
                                <h1 class="text-lg font-bold">{{ $member->user->name }}</h1>
                                <p class="text-xs">{{ $member->user->id }}</p>
                                <img src="{{ asset('storage/' . $member->barcode_path) }}" alt="Barcode" class="mt-2 w-28 h-auto">
                            </div>
                            
                            <div class="absolute bottom-2 left-0 right-0 flex justify-center">
                                <button onclick="printCard('{{ $member->id }}')" 
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-[90%]">
                                    Cetak Kartu
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterCards() {
            let searchInput = document.getElementById("search").value.toLowerCase();
            let cards = document.querySelectorAll("#member-container > div");
            
            cards.forEach(card => {
                let name = card.querySelector("h1").innerText.toLowerCase();
                card.style.display = name.includes(searchInput) ? "block" : "none";
            });
        }
    
        function sortCards() {
            let container = document.getElementById("member-container");
            let cards = Array.from(container.children);
            let sortOrder = document.getElementById("sort").value;
    
            cards.sort((a, b) => {
                let nameA = a.querySelector("h1").innerText.toLowerCase();
                let nameB = b.querySelector("h1").innerText.toLowerCase();
                return sortOrder === "asc" ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
            });
    
            container.innerHTML = "";
            cards.forEach(card => container.appendChild(card));
        }

        function printCard(memberId) {
            let card = document.getElementById(`card-${memberId}`).cloneNode(true);
            card.querySelector("button").remove(); // Hapus tombol cetak sebelum mencetak
            
            let printWindow = window.open('', '', 'width=400,height=600');
            printWindow.document.write('<html><head><title>Cetak Kartu</title></head><body style="display: flex; justify-content: center; align-items: center; height: 100vh;">');
            printWindow.document.write('<div style="width: 85.6mm; height: 53.98mm; background-image: url(\'' + '{{ asset('asset/kartu.png') }}' + '\'); background-size: cover;">');
            printWindow.document.write(card.outerHTML);
            printWindow.document.write('</div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endsection
