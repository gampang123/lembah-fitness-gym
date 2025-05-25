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
            <div class="col align-items-center">
                <a style="color: white; text-decoration: none;" href="{{ route('package-member.index') }}">
                    <div class="package-dashboard">
                        <img style="width: 50px;" src="{{ asset('asset/package.svg') }}" alt="Membership">
                    </div>
                    <b class="mt-2 d-block">Langganan</b>
                </a>
            </div>
            <div class="col align-items-center">
                <a style="color: white; text-decoration: none;" href="{{ route('card-member.index') }}">
                    <div class="package-dashboard">
                        <img style="width: 53px;" src="{{ asset('asset/member-card.svg') }}" alt="Membership">
                    </div>
                    <b class="mt-2 d-block">Kartu Member</b>
                </a>
            </div>
        </div>
    </section>

    <section>
        <div style="background-color: purple" class="row content-dashboard">
            <div class="col">
                <b>Sesi Aktif Saat Ini</b> <br>
                12 jam 30 menit 10 detik
            </div>

            <p style="color: #00ff37;">Tidak ada Sesi</p>
        </div>
    </section>

    <section>
        <div class="container mt-5">
            <h2 class="text-white text-center mb-3">Absensi Fitness Bulan Mei</h2>
            <canvas id="attendanceChart" width="300" height="300"></canvas>
        </div>
    </section>

    <script>
        window.onload = function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            const hadir = 20;
            const tidakHadir = 10;

            const data = {
                labels: ['Hadir', 'Tidak Hadir'],
                datasets: [{
                    label: 'Absensi Fitness',
                    data: [hadir, tidakHadir],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            };

            const config = {
                type: 'doughnut',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'white'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.7)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.parsed || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: ${value} hari (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        };
    </script>

@endsection
