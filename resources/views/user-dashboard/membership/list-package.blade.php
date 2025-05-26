@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard List Paket Member')

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
        <h1>Langganan</h1>
    </section>

    <section style="margin-top: 30px;">
        @forelse($packages as $package)
            <form method="GET" action="{{ route('membership.create', [
                    'package_id' => $package->id,
                    'name' => $package->name,
                    'price' => $package->price,
                    'duration_in_days' => $package->duration_in_days
                ]) }}" class="mb-3">
                <input type="hidden" name="package_id" value="{{ $package->id }}">
                <button type="submit" class="card text-start w-100 border-0 bg-transparent">
                    <h3 class="card-title">{{ $package->name }}</h3>
                    <p class="card-price">Rp{{ number_format($package->price, 0, ',', '.') }} 
                        <span class="per-month">
                            @if($package->duration_in_days == 30)
                                /bulan
                            @else
                                /{{ $package->duration_in_days / 30 }} bulan
                            @endif
                        </span>
                    </p>
                    <ul class="card-features">
                        <li>Akses gym fitness selama {{ $package->duration_in_days }} hari penuh di Lembah Fitness Warungboto</li>
                    </ul>
                </button>
            </form>
        @empty
            <div class="card text-center p-4">
                <h5 class="text-muted mb-0">Tidak ada paket yang tersedia saat ini.</h5>
            </div>
        @endforelse
    </section>
@endsection
