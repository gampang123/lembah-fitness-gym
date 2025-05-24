@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Detail Transaksi')

@section('content')
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('report-transaction-member.index') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>
    <section class="transaction-detail">
        <div class="transaction-card">
            <div class="ribbon"><span>UNPAID</span></div>
            <!-- Logo -->
            <div class="logo-wrapper">
                <img src="{{ asset('asset/logo-circle.svg') }}" alt="Logo" />
            </div>

            <!-- Informasi Pembayaran -->
            <div class="payment-info">
                <p class="label">Pembayaran via</p>
                <p class="value">Online Payment</p>
                <p class="label">Jumlah Pembayaran</p>
                <p class="amount">Rp250.000</p>
            </div>

            <!-- Detail Transaksi -->
            <div style="margin-top: 40px;" class="register-package row text-start">
                <div class="col"><b>Nama</b></div>
                <div class="col">: Fulan bin Fulan
                    <input type="hidden" name="nama" value="Fulan bin Fulan">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Nama Paket</b></div>
                <div class="col">: Paket 1 Bulan
                    <input type="hidden" name="nama_paket" value="Paket 1 Bulan">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Jumlah Hari</b></div>
                <div class="col">: 30 Hari
                    <input type="hidden" name="jumlah_hari" value="30">
                </div>
            </div>
            <div class="register-package row text-start">
                <div class="col"><b>Total</b></div>
                <div class="col">: Rp250.000
                    <input type="hidden" name="total" value="250000">
                </div>
            </div>

            <!-- Tombol -->
            <div class="btn-wrapper">
                <form method="POST" action="/selesai">
                    @csrf
                    <button type="submit" class="finish">Bayar / Selesai</button>
                </form>
            </div>
        </div>
    </section>

@endsection
