@extends('layouts.app')

@section('title', 'Kartu Member')
<style>
    
</style>
@section('content')
<div class="page-container">
    <div class="main-content">
        <div class="page-header">
            <h2 class="header-title">Card Member</h2>
            <div class="header-sub-title">
                <nav class="breadcrumb breadcrumb-dash">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="anticon anticon-home m-r-5"></i>Home</a>
                    <span class="breadcrumb-item active">Card Member</span>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Card Member</h4>
                <input type="text" id="searchInput" placeholder="Cari nama member..." class="mb-4 px-3 py-2 border rounded w-full max-w-md">

                    <div id="cardContainer" class="flex flex-wrap justify-center gap-4"></div>

                    <div id="paginationInfo" class="text-sm mt-2 text-center"></div>

                    <div id="paginationButtons" class="flex flex-wrap justify-center gap-1 mt-4 text-sm"></div>

                    <!-- Ini disembunyikan, jadi JS bisa ambil data -->
                    <div id="allCards" class="hidden">
                        @foreach ($members as $member)
                            <div class="member-card" data-name="{{ strtolower($member->user->name) }}">
                                <div class="relative w-[225px] bg-[#1f1f1f] p-1 rounded mx-auto my-4">
                                    <div class="absolute top-[105px] left-[-7px] w-[7px] h-[100px] bg-[#0a0a0a] rounded-r"></div>
                                    <div class="absolute top-[105px] right-[-7px] w-[7px] h-[100px] bg-[#0a0a0a] rounded-l"></div>
                                    <div class="bg-white p-4 rounded-lg text-center shadow-md">
                                        <h2 class="text-base font-bold">{{ $member->user->name }}</h2>
                                        <div class="my-2">
                                            <img src="{{ asset('storage/' . $member->barcode_path) }}" alt="Barcode" class="w-[100px] mx-auto">
                                        </div>
                                        <h3 class="text-sm font-semibold">Member</h3>
                                        <h3 class="text-sm font-light">{{ $member->user->id }}</h3>
                                        <hr class="my-1">
                                        <p class="text-[10px] my-[2px]"><strong>Lembah Fitness Gym</strong>, Yogyakarta</p>
                                        <button onclick="printCard('{{ $member->id }}')" 
                                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-[90%]">
                                            Cetak Kartu
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cards = Array.from(document.querySelectorAll("#allCards .member-card"));
        const container = document.getElementById("cardContainer");
        const searchInput = document.getElementById("searchInput");
        const paginationInfo = document.getElementById("paginationInfo");
        const paginationButtons = document.getElementById("paginationButtons");

        let filteredCards = [...cards];
        let currentPage = 1;
        const itemsPerPage = 10;

        function renderCards() {
            container.innerHTML = "";
            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageCards = filteredCards.slice(start, end);

            pageCards.forEach(card => {
                container.appendChild(card.cloneNode(true));
            });

            // Show info
            const totalEntries = filteredCards.length;
            const startEntry = start + 1;
            const endEntry = Math.min(end, totalEntries);
            paginationInfo.textContent = `Showing ${startEntry} to ${endEntry} of ${totalEntries} entries`;

            renderPaginationButtons();
        }

        function renderPaginationButtons() {
            paginationButtons.innerHTML = "";

            const totalPages = Math.ceil(filteredCards.length / itemsPerPage);

            const createBtn = (label, page, disabled = false, active = false) => {
                const btn = document.createElement("button");
                btn.textContent = label;
                btn.className = `px-3 py-1 border rounded ${
                    active ? 'bg-blue-500 text-white' : 'bg-white text-black hover:bg-gray-200'
                } ${disabled ? 'opacity-50 cursor-not-allowed' : ''}`;
                if (!disabled && !active) {
                    btn.addEventListener("click", () => {
                        currentPage = page;
                        renderCards();
                    });
                }
                return btn;
            };

            // Prev
            paginationButtons.appendChild(createBtn("<<", currentPage - 1, currentPage === 1));

            // Page numbers (max 5 visible)
            let maxPagesToShow = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
            let endPage = Math.min(startPage + maxPagesToShow - 1, totalPages);

            if (endPage - startPage < maxPagesToShow - 1) {
                startPage = Math.max(1, endPage - maxPagesToShow + 1);
            }

            if (startPage > 1) {
                paginationButtons.appendChild(createBtn("1", 1));
                if (startPage > 2) {
                    paginationButtons.appendChild(createBtn("...", currentPage, true));
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                paginationButtons.appendChild(createBtn(i, i, false, i === currentPage));
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    paginationButtons.appendChild(createBtn("...", currentPage, true));
                }
                paginationButtons.appendChild(createBtn(totalPages, totalPages));
            }

            // Next
            paginationButtons.appendChild(createBtn(">>", currentPage + 1, currentPage === totalPages));
        }

        searchInput.addEventListener("input", function () {
            const keyword = this.value.toLowerCase();
            filteredCards = cards.filter(card => card.dataset.name.includes(keyword));
            currentPage = 1;
            renderCards();
        });

        renderCards();
    });
</script>




