@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Package')

@section('content')
<section>
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-auto">
            <a href="{{ route('member.dashboard') }}">
                <img style="width: 20px;" src="{{ asset('asset/arrow-left .svg') }}" alt="Back">
            </a>
        </div>
    </div>
</section>

<section>
    <h1>Membership</h1>
</section>

<section class="membership-package" style="margin-top: 50px;">
    @if ($activeMemberships->isEmpty())
        <div>
            <p style="font-size: 12px; margin-bottom: 8px; color: rgb(255, 0, 0);" class="text-kiri">
                Anda Tidak Memiliki Paket Apapun
            </p>
            <h2 class="text-kiri"><b>Belum Ada Paket Aktif</b></h2>
            <p class="text-kiri">-</p>
            <p class="text-kiri" style="font-size: 12px; color: #fff;">
                Silakan pilih paket membership dan lakukan pembayaran untuk mengaktifkan.
            </p>
        </div>
    @else
        @php
            $currentMembership = $activeMemberships->first();
        @endphp
        <div>
            <p style="font-size: 12px; margin-bottom: 8px; color: #00ff37;" class="text-kiri">Member saat ini</p>
            <h2 class="text-kiri"><b>{{ $currentMembership->package->name }}</b></h2>
            <p class="text-kiri">Rp{{ number_format($currentMembership->package->price, 0, ',', '.') }}</p>
            <p class="text-kiri" style="font-size: 12px; color: #fff;">
                Berlaku sampai: {{ \Carbon\Carbon::parse($currentMembership->expired_at)->format('d M Y') }}
            </p>
        </div>
    @endif

    <div class="membership-extend">
        <a href="{{ route('membership.list') }}">
            <div class="btn-membership">
                <p style="font-size: 15px;">Perpanjang Membership</p>
                <img style="width: 25px; padding-right: 8px;" src="{{ asset('asset/login.svg') }}" alt="Perpanjang">
            </div>
        </a>
    </div>
</section>
@endsection
