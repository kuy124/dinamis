<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan {{ $table->table_name }}</title>
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
                <h1 class="card-title text-center mb-4">Catatan {{ $table->table_name }}</h1>

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

                <form action="{{ route('tables.add-record', $table) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="month" class="form-label">Bulan</label>
                            <select name="month" id="month" class="form-select @error('month') is-invalid @enderror" required>
                                <option value="">Pilih Bulan</option>
                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                    <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
                            @error('month')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @foreach ($table->fields as $field)
                            <div class="col-md-6">
                                <label for="{{ $field->field_name }}" class="form-label">{{ $field->field_name }}</label>
                                @switch($field->field_type)
                                    @case('number')
                                        <input type="number" id="{{ $field->field_name }}" name="{{ $field->field_name }}" class="form-control @error($field->field_name) is-invalid @enderror" value="{{ old($field->field_name) }}" required>
                                        @break
                                    @case('date')
                                        <input type="date" id="{{ $field->field_name }}" name="{{ $field->field_name }}" class="form-control @error($field->field_name) is-invalid @enderror" value="{{ old($field->field_name) }}" required>
                                        @break
                                    @default
                                        <input type="text" id="{{ $field->field_name }}" name="{{ $field->field_name }}" class="form-control @error($field->field_name) is-invalid @enderror" value="{{ old($field->field_name) }}" required>
                                @endswitch
                                @error($field->field_name)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Catatan
                        </button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Bulan</th>
                                @foreach ($table->fields as $field)
                                    <th>{{ $field->field_name }}</th>
                                @endforeach
                                <th>Aksi</th>
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
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal-{{ $record->id }}">
                                            <i class="fas fa-edit me-1"></i>Ubah
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $record->id }}">
                                            <i class="fas fa-trash-alt me-1"></i>Hapus
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Hapus -->
                                <div class="modal fade" id="deleteModal-{{ $record->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus catatan ini? Tindakan ini tidak dapat dibatalkan.
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('records.delete', $record) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Ubah -->
                                <div class="modal fade" id="updateModal-{{ $record->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Ubah Catatan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('records.update', $record->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="update-month-{{ $record->id }}" class="form-label">Bulan</label>
                                                        <select name="month" id="update-month-{{ $record->id }}" class="form-select" required>
                                                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                                                <option value="{{ $month }}" {{ $record->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    @foreach ($table->fields as $field)
                                                        <div class="mb-3">
                                                            <label for="update-{{ $field->field_name }}-{{ $record->id }}" class="form-label">{{ $field->field_name }}</label>
                                                            <input type="{{ $field->field_type }}" id="update-{{ $field->field_name }}-{{ $record->id }}" name="{{ $field->field_name }}" value="{{ $record->data[$field->field_name] ?? '' }}" class="form-control" required>
                                                        </div>
                                                    @endforeach

                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="{{ count($table->fields) + 2 }}" class="text-center">Tidak ada catatan ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <a href="{{ route('tables.index') }}" class="btn btn-secondary">
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