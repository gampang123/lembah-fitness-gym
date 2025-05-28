@extends('user-dashboard.layouts.menu')

@section('title', 'Dashboard Member')

@section('content')
    <section>
        <div class="profile-card">
            <img src="{{ asset('asset/user.svg') }}" alt="Profile Photo" class="profile-img">
            <div class="profile-text">
                <p>Hello!</p>
                <h2>{{ Auth::user()->name }}</h2>
            </div>
        </div>
    </section>
    <section>
        <div class="content-dashboard">
            <h2><b>Selamat Datang <br>di Lembah Fitness</b></h2>
            @if ($membershipCheck->status == 'active')
                <div class="status-member" style="background-color: #28a745; color: white;">
                    Aktif
                </div>
            @elseif ($membershipCheck->status == 'expired')
                <div class="status-member" style="background-color: #dc3545; color: white;">
                    Tidak Aktif
                </div>
            @endif
        </div>
    </section>
    <section>
        <div class="row text-center">
            <div class="col align-items-center">
                <a style="color: white; text-decoration: none;" href="{{ route('membership.index') }}">
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
                @if ($todayPresence && $todayPresence->scan_out_at == null)
                    <span id="session-time"></span>

                    {{-- Kirim waktu scan_in_at ke JS --}}
                    <script>
                        const scanInAt = new Date("{{ \Carbon\Carbon::parse($todayPresence->scan_in_at)->format('Y-m-d H:i:s') }}");
                    </script>
                @else
                    <p style="color: #00ff37;">Tidak ada Sesi</p>
                @endif
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-5">
            <h2 class="text-white text-center mb-3">Absensi Fitness Bulan Mei</h2>
            <canvas id="attendanceChart" width="300" height="300"></canvas>
        </div>
    </section>
    <!-- Modal QR -->
    <div id="modalQr" class="modal">
        <div class="modal-content qr-content" style="background-color: white">
            <span style="color: black" class="close-btn" onclick="closeModal('modalQr')">&times;</span>
            <div class="qr-wrapper">
                <img src="{{ asset('storage/' . $membershipCheck->barcode_path) }}" alt="QR Code" class="qr-image">
            </div>
        </div>
    </div>
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = "flex";
        }

        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // Klik luar modal untuk menutup
        window.onclick = function(event) {
            document.querySelectorAll('.modal').forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            });
        };
    </script>

    <script>
        window.onload = function() {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            const hadir = {{ $hadirCount }};
            const tidakHadir = {{ $tidakHadirCount }};

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

    @if ($todayPresence && $todayPresence->scan_out_at == null)
    <script>
        function updateSessionTime() {
            const now = new Date();
            const diffMs = now - scanInAt;
            const diff = new Date(diffMs);

            const hours = Math.floor(diffMs / (1000 * 60 * 60));
            const minutes = diff.getUTCMinutes();
            const seconds = diff.getUTCSeconds();

            document.getElementById("session-time").textContent =
                `${hours} jam ${minutes} menit ${seconds} detik`;
        }

        setInterval(updateSessionTime, 1000);
        updateSessionTime();
    </script>
    @endif

@endsection
