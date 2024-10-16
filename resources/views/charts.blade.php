<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Dinamis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
        --background-color: #f8f9fc;
        --card-background: #ffffff;
        --text-color: #5a5c69;
    }

    body {
        background-color: var(--background-color);
        font-family: 'Nunito', sans-serif;
        color: var(--text-color);
    }

    .navbar {
        background-color: var(--primary-color);
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }

    .navbar-brand {
        color: #ffffff;
        font-weight: 700;
    }

    .card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        background-color: var(--card-background);
    }

    .card-title {
        color: var(--primary-color);
        font-weight: 700;
    }

    .btn-floating {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 100;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .btn-floating:hover {
        transform: scale(1.1);
    }

    .filter-card {
        background-color: #f1f3f9;
        border-left: 5px solid var(--primary-color);
    }

    .chart-container {
        position: relative;
        margin: auto;
        height: 350px;
        width: 100%;
    }

    @media (max-width: 768px) {
        .chart-container {
            height: 300px;
        }
    }

    .chart-wrapper {
        transition: all 0.3s ease;
    }
    
    .chart-wrapper.full-width {
        width: 100%;
    }
    
    .chart-container {
        transition: height 0.3s ease;
    }
</style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-chart-line me-2"></i>Grafik Dinamis
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="card filter-card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Filter Grafik</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="monthFilter" class="form-label">Pilih Bulan</label>
                        <select id="monthFilter" class="form-select" onchange="updateCharts()">
                            <option value="">Semua Bulan</option>
                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="chartType" class="form-label">Jenis Grafik</label>
                        <select id="chartType" class="form-select" onchange="updateChartType()">
                            <option value="bar">Batang</option>
                            <option value="line">Garis</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="chartSelector" class="form-label">Pilih Chart</label>
                        <select id="chartSelector" class="form-select" onchange="showSelectedChart()">
                            <option value="all">Semua Chart</option>
                            @foreach ($tables as $table)
                                <option value="chart-{{ $table->id }}">{{ $table->table_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="chartsContainer">
            @foreach ($tables as $table)
                <div class="col-lg-6 mb-4 chart-wrapper" data-chart-id="chart-{{ $table->id }}">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">{{ $table->table_name }}</h5>
                            <div class="chart-container">
                                <canvas id="chart-{{ $table->id }}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="javascript:void(0)" class="btn btn-primary btn-floating" onclick="history.back()">
            <i class="fas fa-arrow-left"></i>
        </a>
    </div>

    <script>
        // Sisanya script JavaScript tetap sama seperti sebelumnya
        const charts = {};
        const colorPalette = [
            ['#FF6384', '#FF9F40', '#FFCE56'],
            ['#36A2EB', '#4BC0C0', '#9966FF'],
            ['#FF9F40', '#FF6384', '#4BC0C0'],
            ['#9966FF', '#36A2EB', '#FFCE56'],
        ];

        function getColorSet(index) {
            return colorPalette[index % colorPalette.length];
        }

        const monthFilter = document.getElementById('monthFilter');
        const chartType = document.getElementById('chartType');

        @foreach ($tables as $index => $table)
            const records{{ $table->id }} = {!! json_encode($table->records) !!};
            const chartData{{ $table->id }} = {
                labels: records{{ $table->id }}.map(record => record.month),
                datasets: [
                    @foreach ($table->fields as $fieldIndex => $field)
                        @if ($field->field_type === 'number')
                            {
                                label: '{{ $field->field_name }}',
                                data: records{{ $table->id }}.map(record => record.data['{{ $field->field_name }}']),
                                backgroundColor: getColorSet({{ $index }})[{{ $fieldIndex % 3 }}] + '80',
                                borderColor: getColorSet({{ $index }})[{{ $fieldIndex % 3 }}],
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4
                            },
                        @endif
                    @endforeach
                ]
            };

            const ctx{{ $table->id }} = document.getElementById('chart-{{ $table->id }}').getContext('2d');
            charts['chart-{{ $table->id }}'] = new Chart(ctx{{ $table->id }}, {
                type: 'bar',
                data: chartData{{ $table->id }},
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#666'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom',
                            labels: {
                                color: '#333'
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        @endforeach

        function updateCharts() {
            const selectedMonth = monthFilter.value;

            @foreach ($tables as $table)
                const filteredRecords{{ $table->id }} = selectedMonth ? records{{ $table->id }}.filter(record => record.month === selectedMonth) : records{{ $table->id }};
                const filteredChartData{{ $table->id }} = {
                    labels: filteredRecords{{ $table->id }}.map(record => record.month),
                    datasets: chartData{{ $table->id }}.datasets.map(dataset => ({
                        ...dataset,
                        data: filteredRecords{{ $table->id }}.map(record => record.data[dataset.label])
                    }))
                };

                charts['chart-{{ $table->id }}'].data = filteredChartData{{ $table->id }};
                charts['chart-{{ $table->id }}'].update();
            @endforeach
        }

        function updateChartType() {
            const newType = chartType.value;
            Object.values(charts).forEach(chart => {
                chart.config.type = newType;
                chart.update();
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateCharts();
        });


        function showSelectedChart() {
    const selectedChart = document.getElementById('chartSelector').value;
    const chartWrappers = document.querySelectorAll('.chart-wrapper');
    
    chartWrappers.forEach(wrapper => {
        if (selectedChart === 'all') {
            wrapper.style.display = 'block';
            wrapper.classList.remove('full-width');
            wrapper.querySelector('.chart-container').style.height = '350px';
        } else if (wrapper.dataset.chartId === selectedChart) {
            wrapper.style.display = 'block';
            wrapper.classList.add('full-width');
            wrapper.querySelector('.chart-container').style.height = '600px';
        } else {
            wrapper.style.display = 'none';
        }
    });

    // Memperbarui tata letak grafik yang ditampilkan
    Object.values(charts).forEach(chart => {
        chart.resize();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateCharts();
    showSelectedChart(); // Panggil ini untuk menginisialisasi tampilan
});

// Tambahkan event listener untuk perubahan ukuran window
window.addEventListener('resize', function() {
    showSelectedChart();
});
    </script>
</body>

</html>