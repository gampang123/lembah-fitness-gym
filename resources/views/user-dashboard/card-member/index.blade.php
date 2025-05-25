@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Riwayat Transaksi')

@section('content')

    <link rel="stylesheet" href="{{ asset('common/css/id-card.css') }}">
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('member.dashboard') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">
                </a>
            </div>
        </div>
    </section>
    <section class=" card-member bg-white pb-4">
        <div class="id-card-tag"></div>
        <div class="id-card-tag-strip"></div>
        <div class="id-card-hook"></div>
        <div class="id-card-holder">
            <div class="id-card">
                <div class="header">
                    <img src="{{ asset('asset/logo.png') }}">
                </div>
                <div class="photo">
                    <img src="{{ asset('asset/qrr.svg') }}">
                </div>
                <h2>Fulan Bin Fulan</h2>
                <div class="qr-code">

                </div>
                <h3>Member</h3>
                <h3>LF19GCS121</h3>
                <hr>
                <p><strong>Lembah Fitness Warungboto</strong><br>
                    DisWarungboto, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa, Kota Yogyakarta, Daerah Istimewa
                    Yogyakarta 55161
                </p>
            </div>
        </div>
    </section>

@endsection
