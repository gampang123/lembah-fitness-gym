@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Page Container START -->
    <div class="page-container">
        <!-- Content Wrapper START -->
        <div class="main-content">
            <div class="page-header no-gutters">
                <div class="d-md-flex align-items-md-center justify-content-between">
                    <div class="media m-v-10 align-items-center">
                        <div style="border-radius: 0px; background-color: transparent;" class="avatar avatar-image avatar-lg">
                            <img src="{{ asset('asset/user.svg') }}" alt="">
                        </div>
                        <div class="media-body m-l-15">
                            <h4 class="m-b-0">Selamat datang, {{ Auth::user()->name }}</h4>
                            <span class="text-gray">{{ Auth::user()->role->name }}</span>
                        </div>
                    </div>
                    <div class="d-md-flex align-items-center d-none">
                        <div class="media align-items-center m-r-40 m-v-5">
                            <div class="font-size-27">
                                <i class="text-primary anticon anticon-check-circle"></i>
                            </div>
                            <div class="d-flex align-items-center m-l-10">
                                <h2 class="m-b-0 m-r-5">{{ $activeMember }}</h2>
                                <span class="text-gray">Member Aktif</span>
                            </div>
                        </div>
                        <div class="media align-items-center m-r-40 m-v-5">
                            <div class="font-size-27">
                                <i class="text-danger anticon anticon-close-circle"></i>
                            </div>
                            <div class="d-flex align-items-center m-l-10">
                                <h2 class="m-b-0 m-r-5">{{ $inactiveMember }}</h2>
                                <span class="text-gray">Tidak Aktif</span>
                            </div>
                        </div>
                        <div class="media align-items-center m-v-5">
                            <div class="font-size-27">
                                <i class="text-danger anticon anticon-team"></i>
                            </div>
                            <div class="d-flex align-items-center m-l-10">
                                <h2 class="m-b-0 m-r-5">{{ $countMember }}</h2>
                                <span class="text-gray">Member</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('content-dashboard.income-chart')
                </div>
            </div>

            {{-- PRESENSI HARIAN --}}
            <div class="row">
                <div class="col-lg-12">
                    @include('content-dashboard.precence-chart')
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Transaksi Terbaru</h5>
                                <div>
                                    <a href="{{ route('transaction.index') }}" class="btn btn-sm btn-primary">Lihat Semua
                                        Data Transaksi</a>
                                </div>
                            </div>
                            <div class="m-t-30">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Member</th>
                                                <th>Tanggal</th>
                                                <th>Paket</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($latestTransactions as $transaction)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <h6 class="m-l-10 m-b-0">
                                                                {{ $transaction->member->user->name ?? 'Nama Tidak Tersedia' }}
                                                            </h6>
                                                        </div>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                                    <td>{{ $transaction->package->name ?? '-' }}</td>
                                                    <td>Rp
                                                        {{ number_format($transaction->package->price ?? 0, 0, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            @php
                                                                $status = strtolower($transaction->status);
                                                                $badgeClass = match ($status) {
                                                                    'paid' => 'badge-success',
                                                                    'pending' => 'badge-warning',
                                                                    'cancelled' => 'badge-danger',
                                                                    'expired' => 'badge-danger',
                                                                    default => 'badge-secondary',
                                                                };
                                                            @endphp
                                                            <span
                                                                class="badge {{ $badgeClass }} badge-dot m-r-10"></span>
                                                            <span>{{ ucfirst($status) }}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5>Paket Terlaris</h5>
                                <div>
                                    <a href="{{ route('paket.index') }}" class="btn btn-sm btn-primary">Lihat Data
                                        Paket</a>
                                </div>
                            </div>
                            <div class="m-t-30">
                                <ul class="list-group list-group-flush">
                                    @forelse($topPackages as $item)
                                        @php
                                            $package = $item->package;
                                        @endphp
                                        <li class="list-group-item p-h-0">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex">
                                                    <div>
                                                        <h6 class="m-b-0">
                                                            <a href="javascript:void(0);"
                                                                class="text-dark">{{ $package->name ?? '-' }}</a>
                                                        </h6>
                                                        <span class="text-muted font-size-13">
                                                            Rp {{ number_format($package->price ?? 0, 0, ',', '.') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="badge badge-pill badge-cyan font-size-12">
                                                    <span class="font-weight-semibold">{{ $item->total_sales }}
                                                        transaksi</span>
                                                </span>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="list-group-item p-h-0 text-center text-muted">
                                            Tidak ada data paket.
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5>Data Umur Member Lembah Fitness</h5>
                            <div class="m-v-45 text-center" style="width: 100%; height: 220px">
                                <canvas class="chart" id="customer-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5>Data Jenis Kelamin Lembah Fitness</h5>
                                                                            <div class="m-v-45 text-center" style="height: 220px">
                                                                                <canvas class="chart" id="customer-chart"></canvas>
                                                                            </div>
                                                                            <div class="row p-t-25">
                                                                                <div class="col-md-8 m-h-auto">
                                                                                    <div class="d-flex justify-content-between align-items-center m-b-20">
                                                                                        <p class="m-b-0 d-flex align-items-center">
                                                                                            <span class="badge badge-warning badge-dot m-r-10"></span>
                                                                                            <span>Direct</span>
                                                                                        </p>
                                                                                        <h5 class="m-b-0">350</h5>
                                                                                    </div>
                                                                                    <div class="d-flex justify-content-between align-items-center m-b-20">
                                                                                        <p class="m-b-0 d-flex align-items-center">
                                                                                            <span class="badge badge-primary badge-dot m-r-10"></span>
                                                                                            <span>Referral</span>
                                                                                        </p>
                                                                                        <h5 class="m-b-0">450</h5>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
            </div>
        </div>

        <script>
            const ageLabels = {!! json_encode($ageChartLabels) !!}; // Contoh: [17, 18, 19, 20]
            const ageCounts = {!! json_encode($ageChartCounts) !!}; // Contoh: [2, 4, 7, 5]

            // Generate warna acak untuk setiap bar
            function getRandomColor() {
                const letters = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
            const backgroundColors = ageLabels.map(() => getRandomColor());

            const ctxCustomer = document.getElementById('customer-chart').getContext('2d');

            const customerChart = new Chart(ctxCustomer, {
                type: 'bar',
                data: {
                    labels: ageLabels.map(label => `${label} tahun`),
                    datasets: [{
                        label: 'Jumlah Member',
                        data: ageCounts,
                        backgroundColor: backgroundColors,
                        borderRadius: 4,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Orang'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Usia'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.parsed.y} orang`;
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endsection
