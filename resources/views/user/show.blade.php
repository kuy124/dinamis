<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola {{ $table->table_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">{{ $table->table_name }}</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
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

                <div class="mt-4">
                    <a href="{{ route('user.user') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Tabel
                    </a>
                    <a href="{{ route('charts') }}" class="btn btn-primary">
                        <i class="fas fa-chart-bar me-2"></i>Lihat Grafik
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
