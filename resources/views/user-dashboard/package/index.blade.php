@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Package')

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
        <h1>Daftar Paket</h1>
    </section>
    <section>
        <div class="content-package">
            <h2 class="text-kiri"><b>Paket 1 Bulan</b></h2>
            <p class="text-kiri">Rp250.000</p>
            <a href="{{ route('package-member.create') }}">
                <div class="botton-Register">Daftar</div>
            </a>
        </div>
    </section>

@endsection
