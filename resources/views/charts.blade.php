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
        body {
            background-color: #f8f9fa;
        }
    
        .card {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 0.5rem;
            padding: 10px; /* Mengurangi padding */
        }
    
        .card.chart-card {
            width: 100%; /* Menjaga ukuran yang responsif */
            max-width: 600px; /* Membuat ukuran card lebih kecil */
            margin: auto; /* Agar card berada di tengah */
        }
    
        .card-title {
            color: #0d6efd;
            font-weight: bold;
        }
    
        .btn-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
        }
    </style>
    
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-5">Grafik Dinamis</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Filter Grafik</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="monthFilter" class="form-label">Pilih Bulan</label>
                        <select id="monthFilter" class="form-select" onchange="updateCharts()">
                            <option value="">Semua Bulan</option>
                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="chartType" class="form-label">Jenis Grafik</label>
                        <select id="chartType" class="form-select" onchange="updateChartType()">
                            <option value="bar">Batang</option>
                            <option value="line">Garis</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="chartsContainer">
            @foreach ($tables as $table)
                <div class="col-md-6 mb-4">
                    <div class="card chart-card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $table->table_name }}</h5>
                            <canvas id="chart-{{ $table->id }}" height="300"></canvas>
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
        const charts = {};
        const colorPalette = [
            ['#FF6384', '#FF9F40', '#FFCE56'], // Palette 1
            ['#36A2EB', '#4BC0C0', '#9966FF'], // Palette 2
            ['#FF9F40', '#FF6384', '#4BC0C0'], // Palette 3
            ['#9966FF', '#36A2EB', '#FFCE56'], // Palette 4
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
                                data: records{{ $table->id }}.map(record => record.data[
                                    '{{ $field->field_name }}']),
                                backgroundColor: getColorSet({{ $index }})[{{ $fieldIndex % 3 }}] + '80',
                                borderColor: getColorSet({{ $index }})[{{ $fieldIndex % 3 }}],
                                borderWidth: 2,
                                fill: true,
                                tension: 0.4 // Adding tension for smoother lines in line charts
                            },
                        @endif
                    @endforeach
                ]
            };

            const ctx{{ $table->id }} = document.getElementById('chart-{{ $table->id }}').getContext('2d');
            charts['chart-{{ $table->id }}'] = new Chart(ctx{{ $table->id }}, {
                type: 'bar', // Default to bar
                data: chartData{{ $table->id }},
                options: {
                    responsive: true,
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
                const filteredRecords{{ $table->id }} = selectedMonth ? records{{ $table->id }}.filter(record =>
                    record.month === selectedMonth) : records{{ $table->id }};
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
    </script>
</body>

</html>
