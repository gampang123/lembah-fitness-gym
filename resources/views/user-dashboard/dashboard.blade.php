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
        <div class="row text-center">
            <div class="col d-flex flex-column align-items-center">
                <a style="color: white; text-decoration: none;" href="{{ route('package-member.index') }}">
                    <div class="package-dashboard">
                        <img style="width: 40px;" src="{{ asset('asset/package.svg') }}" alt="Membership">
                    </div>
                    <b class="mt-2 d-block">Langganan</b>
                </a>
            </div>
            <div class="col"></div>
            <div class="col"></div>
        </div>
    </section>
@endsection
