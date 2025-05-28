@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Presensi')

@section('content')
    <!-- Konten Atas -->
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('membership.index') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">
                </a>
            </div>
            <div class="col-auto">
                <a href="#" id="btnFilter">
                    <img src="{{ asset('common/dashboard/assets/images/svg/button-filter.svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>

    <!-- Judul -->
    <section>
        <h1>Riwayat Kehadiran</h1>
    </section>

    <!-- Daftar Presensi -->
    <section style="margin-top: 30px;">
        @forelse ($presences as $presence)
            <div class="schedule-box">
                <div class="schedule-date">
                    <span class="dot"></span>
                    <span class="date-text">
                        {{ \Carbon\Carbon::parse($presence->created_at)->translatedFormat('d F Y') }}
                    </span>
                </div>
                <div class="schedule-time">
                    {{ \Carbon\Carbon::parse($presence->scan_in_at)->format('H:i:s') }} – {{ $presence->scan_out_at ? \Carbon\Carbon::parse($presence->scan_out_at)->format('H:i:s') : 'Now' }}
                </div>
            </div>
        @empty
            <div class="text-center text-white" style="margin-top: 50px;">
                <p style="margin-top: 15px;">Belum ada data presensi.</p>
            </div>
        @endforelse
    </section>

    <!-- Popup Filter -->
    <div id="filter-popup" class="popup-filter-window">
        <a href="#" id="close-filter-popup">
            <img src="{{ asset('common/dashboard/assets/images/svg/x.svg') }}" alt="x">
        </a>
        <div class="filter-form-section">
            <div>
                Tahun <br>
                <div class="col-md-9">
                    <select name="filter_year">
                        <option value="" disabled selected>Pilih tahun</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
            </div>
            <div style="margin-top: 15px;">
                Bulan <br>
                <div class="col-md-9">
                    <select name="filter_month">
                        <option value="" disabled selected>Pilih bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtn = document.getElementById('btnFilter');
            const closeBtn = document.getElementById('close-filter-popup');
            const popup = document.getElementById('filter-popup');

            filterBtn.addEventListener('click', function(e) {
                e.preventDefault();
                popup.classList.add('active');
            });

            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                popup.classList.remove('active');
            });
        });
    </script>
@endsection
