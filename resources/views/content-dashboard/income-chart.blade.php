<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5>Pendapatan Lembah Fitness Tahun {{ $selectedYear }}</h5>
            <form method="GET" action="{{ url('/dashboard') }}">
                <select name="year" onchange="this.form.submit()" class="form-control form-control-sm">
                    @foreach ($years as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="mt-4" style="width: 100%; height: 300px;">
            <canvas id="revenue-chart"></canvas>
        </div>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenue-chart').getContext('2d');

    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Pendapatan (Rp)',
                data: [
                    @for ($i = 1; $i <= 12; $i++)
                        {{ $monthlyRevenue[$i] }},
                    @endfor
                ],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#007bff',
                borderWidth: 2,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            responsive: true,
            maintainAspectRatio: false,
        }
    });
</script>
