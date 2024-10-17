<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola {{ $table->table_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #4e73df;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transition: transform 0.3s;
        }
        /* .card:hover {
            transform: translateY(-5px);
        } */
        .table th {
            background-color: #4e73df;
            color: white;
        }
        /* .table-hover tbody tr:hover {
            background-color: #ecf0f1;
        } */
        .btn-custom {
            border-radius: 20px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            transform: scale(1.02);
            /* transform: translateY(-2px); */
        }
        .animate-fade {
            animation: fadeIn 0.5s;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-table me-2"></i>{{ $table->table_name }}
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card animate-fade mb-4">
                    <div class="card-body">
                        <h2 class="card-title mb-4">
                            <i class="fas fa-list me-2"></i>Data {{ $table->table_name }}
                        </h2>

                        @if ($errors->any())
                            <div class="alert alert-danger animate-fade">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success animate-fade">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        @foreach ($table->fields as $field)
                                            <th>{{ $field->field_name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($records as $record)
                                        <tr>
                                            <td>{{ $record->month }}</td>
                                            @foreach ($table->fields as $field)
                                                <td>
                                                    @switch($field->field_type)
                                                        @case('date')
                                                            {{ \Carbon\Carbon::parse($record->data[$field->field_name])->format('d/m/Y') }}
                                                            @break
                                                        @case('number')
                                                            {{ number_format($record->data[$field->field_name], 2, ',', '.') }}
                                                            @break
                                                        @default
                                                            {{ $record->data[$field->field_name] }}
                                                    @endswitch
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($table->fields) + 2 }}" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card animate-fade mb-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">
                            <i class="fas fa-chart-pie me-2"></i>Statistik
                        </h3>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total Data
                                <span class="badge bg-primary rounded-pill">{{ count($records) }}</span>
                            </li>
                            <!-- Tambahkan statistik lainnya di sini -->
                        </ul>
                    </div>
                </div>
                <div class="card animate-fade">
                    <div class="card-body">
                        <h3 class="card-title mb-4">
                            <i class="fas fa-cog me-2"></i>Aksi
                        </h3>
                        <div class="d-grid gap-2">
                            <a href="{{ route('user.user') }}" class="btn btn-outline-secondary btn-custom">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Tabel
                            </a>
                            <a href="{{ route('charts') }}" class="btn btn-primary btn-custom">
                                <i class="fas fa-chart-bar me-2"></i>Lihat Grafik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi fade-in untuk elemen-elemen saat halaman dimuat
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('.animate-fade').forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                }, index * 100);
            });
        });

        // Highlight baris tabel saat di-hover
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseover', () => {
                row.style.backgroundColor = '#e8f4f8';
            });
            row.addEventListener('mouseout', () => {
                row.style.backgroundColor = '';
            });
        });
    </script>
</body>
</html>