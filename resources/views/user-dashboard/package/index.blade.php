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
        <h1>Membership</h1>
    </section>

    {{-- NO JOINED MEMBERSHIP --}}
    <section style="margin-top: 50px;">
        <p style="font-size: 12px; margin-bottom: 8px; color: #00ff37; text-align: center;">Anda Tidak Memiliki Paket Apapun
        </p>
    </section>
    {{-- END NO JOINED MEMBERSHIP --}}

    <section class="membership-package">
        <div>
            <p style="font-size: 12px; margin-bottom: 8px; color: #00ff37;" class="text-kiri">Member saat ini</p>
            <h2 class="text-kiri"><b>Paket 1 Bulan</b></h2>
            <p class="text-kiri">Rp250.000</p>
        </div>
        <div class="membership-extend">
            <a href="{{ route('package-member.list') }}">
                <div class="btn-membership">
                    <p style="font-size: 15px;">Perpanjang Membership</p>
                    <img style="width: 25px; padding-right: 8px;" src="{{ asset('asset/login.svg') }}" alt="">
                </div>
            </a>
        </div>
    </section>
@endsection
