@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard List Paket Member')

@section('content')
    <section>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <a href="{{ route('member.dashboard') }}">
                    <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="">

                </a>
            </div>
        </div>
    </section>

    <section>
        <h1>Langganan</h1>
    </section>

    <section style="margin-top: 30px;">
        <a href="{{ route('package-member.create') }}">
            <div class="card">
                <h3 class="card-title">Langganan 1 Bulan</h3>
                <p class="card-price">Rp250.000 <span class="per-month">/bulan</span></p>
                <ul class="card-features">
                    <li>Akses gym fitness selama 1 bulan Penuh di Lembah Fitness Warungboto</li>
                </ul>
            </div>
        </a>
        <a href="{{ route('package-member.create') }}">
            <div class="card">
                <h3 class="card-title">Langganan 3 Bulan</h3>
                <p class="card-price">Rp600.000 <span class="per-month">/3 bulan</span></p>
                <ul class="card-features">
                    <li>Akses gym fitness selama 1 bulan Penuh di Lembah Fitness Warungboto</li>
                </ul>
            </div>
        </a>
    </section>
@endsection
