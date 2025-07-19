    <div class="card" style="background-color: #e7e7e7">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Presensi Kehadiran </h5>
                <div class="dropdown dropdown-animated scale-left">
                    {{-- <a class="text-gray font-size-18" href="javascript:void(0);" data-toggle="dropdown">
                        <i class="anticon anticon-ellipsis"></i>
                    </a> --}}
                    <div class="d-flex align-items-center gap-2">
                        <label for="range-type" class="mb-0 mr-2">Filter:</label>
                        <select id="range-type" class="form-control form-control-sm w-auto">
                            <option value="daily" selected>Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                    </div>

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
        function fetchPresenceData(date, rangeType = 'daily') {
            fetch(`/presence-chart?date=${date}&range_type=${rangeType}`)
                .then(res => res.json())
                .then(data => {
                    initChart(data.labels, data.counts);
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const formattedToday = today.toISOString().split('T')[0];

            fetchPresenceData(formattedToday, 'daily');

            $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    todayHighlight: true
                }).datepicker('setDate', today)
                .on('changeDate', function(e) {
                    const selectedDate = e.format('yyyy-mm-dd');
                    const rangeType = document.getElementById('range-type').value;
                    fetchPresenceData(selectedDate, rangeType);
                });

            document.getElementById('range-type').addEventListener('change', function() {
                const selectedDate = $('#datepicker').datepicker('getFormattedDate');
                fetchPresenceData(selectedDate, this.value);
            });
        });
    </script>
