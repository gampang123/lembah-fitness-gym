@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Member')

@section('content')
    <section>
        <div class="profile-card">
            <img src="{{ asset('asset/user.svg') }}" alt="Profile Photo" class="profile-img">
            <div class="profile-text">
                <p>Hello!</p>
                <h2>MORGAN MAXWELL</h2>
            </div>
        </div>
    </section>
    <section>
        <div class="content-dashboard">
            <h2><b>Selamat Datang <br>di Lembah Fitness</b></h2>
            <div class="status-member">Member Aktif</div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col">
                <a style="color: white" href="{{ route('package-member.index') }}">
                    <div class="package-dahboard">
                        <img style="width: 40px;" src="{{ asset('asset/package.svg') }}" alt="">
                    </div>
                    <b> Paket</b>
                </a>
            </div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
    </section>
@endsection
