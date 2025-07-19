    <div class="card" style="background-color: #e7e7e7">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Presensi Kehadiran </h5>
                <div class="dropdown dropdown-animated scale-left">
                    <a class="text-gray font-size-18" href="javascript:void(0);" data-toggle="dropdown">
                        <i class="anticon anticon-ellipsis"></i>
                    </a>
                </div>
            </div>
            <div class="d-md-flex justify-content-space m-t-50">
                <div class="completion-chart p-r-10">
                    <canvas class="chart" id="presenceChart"></canvas>
                </div>
                <div class="calendar-card border-0">
                    <div id="datepicker" data-provide="datepicker-inline"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let chart;

        function initChart(labels, data) {
            const ctx = document.getElementById('presenceChart').getContext('2d');
            if (chart) chart.destroy();

            chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Presensi',
                        data: data,
                        borderColor: '#4d8af0',
                        backgroundColor: '#4d8af033',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Jam Kehadiran'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : null;
                                }
                            },
                            suggestedMin: 0,
                            suggestedMax: Math.max(...data) < 10 ? 10 : undefined,
                            title: {
                                display: true,
                                text: 'Jumlah Orang Yang Datang'
                            }
                        }
                    }
                }
            });
        }

        function fetchPresenceData(date) {
            fetch(`/presence-chart?date=${date}`)
                .then(res => res.json())
                .then(data => {
                    initChart(data.labels, data.counts);
                });
        }

        // On page load
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const formattedToday = today.toISOString().split('T')[0];

            // Inisialisasi chart dengan data hari ini
            fetchPresenceData(formattedToday);

            // Inisialisasi datepicker dan atur tanggal default ke hari ini
            $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    todayHighlight: true
                }).datepicker('setDate', today) // ini membuat hari ini aktif
                .on('changeDate', function(e) {
                    const selectedDate = e.format('yyyy-mm-dd');
                    fetchPresenceData(selectedDate);
                });
        });
    </script>
