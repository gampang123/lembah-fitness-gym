@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Riwayat Transaksi')

@section('content')
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('member.dashboard') }}">
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
    <section>
        <h1>Riwayat Transaksi</h1>
    </section>

    <section style="margin-top: 30px;">
        <a href="{{ url('test-detail-transaksi') }}">
            <div class="payment-card">
                <div class="card-left">
                    <div class="icon-circle">
                        <span class="icon">$</span>
                    </div>
                    <div class="info">
                        <strong>Paket 1 Bulan</strong>
                        <div class="date">1 November 2025</div>
                    </div>
                </div>
                <div class="card-right">
                    <strong>Rp250.000</strong>
                    <div class="status pending">Pending</div>
                </div>
            </div>
        </a>
        <a href="">
            <div style="margin-top: 8px;" class="payment-card">
                <div class="card-left">
                    <div class="icon-circle">
                        <span class="icon">$</span>
                    </div>
                    <div class="info">
                        <strong>Paket 1 Bulan</strong>
                        <div class="date">1 November 2025</div>
                    </div>
                </div>
                <div class="card-right">
                    <strong>Rp250.000</strong>
                    <div style="color: red;" class="status pending">Cancel</div>
                </div>
            </div>
        </a>
        <a href="">
            <div style="margin-top: 8px;" class="payment-card">
                <div class="card-left">
                    <div class="icon-circle">
                        <span class="icon">$</span>
                    </div>
                    <div class="info">
                        <strong>Paket 1 Bulan</strong>
                        <div class="date">1 November 2025</div>
                    </div>
                </div>
                <div class="card-right">
                    <strong>Rp250.000</strong>
                    <div style="color: green;" class="status pending">Success</div>
                </div>
            </div>
        </a>

    </section>


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
            <div class="btn-wrapper">
                <button class="finish">Cari</button>
            </div>
        </div>
    </div>

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



@endsection
