<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan {{ $table->table_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            background-color: var(--light-color);
            font-family: 'Nunito', sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 1rem 1.5rem;
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
        }

        .table thead th {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .btn {
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .alert {
            border-radius: 15px;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            border-radius: 15px 15px 0 0;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: var(--light-color);
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .actions-column {
            width: 150px;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="sticky-header mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Catatan {{ $table->table_name }}</h1>
                <div>
                    <a href="{{ route('tables.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('charts') }}" class="btn btn-primary">
                        <i class="fas fa-chart-bar me-2"></i>Lihat Grafik
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card animate-fade-in">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Catatan Baru</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('tables.add-record', $table) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="month" class="form-label">Bulan</label>
                                <select name="month" id="month" class="form-select @error('month') is-invalid @enderror" required>
                                    <option value="">Pilih Bulan</option>
                                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                        <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @foreach ($table->fields as $field)
                                <div class="mb-3">
                                    <label for="{{ $field->field_name }}" class="form-label">{{ $field->field_name }}</label>
                                    @switch($field->field_type)
                                        @case('number')
                                            <input type="number" id="{{ $field->field_name }}" name="{{ $field->field_name }}"
                                                class="form-control @error($field->field_name) is-invalid @enderror"
                                                value="{{ old($field->field_name) }}" step="0.01" required>
                                        @break

                                        @case('date')
                                            <input type="date" id="{{ $field->field_name }}" name="{{ $field->field_name }}"
                                                class="form-control @error($field->field_name) is-invalid @enderror"
                                                value="{{ old($field->field_name) }}" required>
                                        @break

                                        @default
                                            <input type="text" id="{{ $field->field_name }}" name="{{ $field->field_name }}"
                                                class="form-control @error($field->field_name) is-invalid @enderror"
                                                value="{{ old($field->field_name) }}" required>
                                    @endswitch
                                    @error($field->field_name)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-plus-circle me-2"></i>Tambah Catatan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card animate-fade-in">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-table me-2"></i>Daftar Catatan</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        @foreach ($table->fields as $field)
                                            <th>{{ $field->field_name }}</th>
                                        @endforeach
                                        <th class="actions-column">Aksi</th>
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
                                                            {{ number_format((float) $record->data[$field->field_name], 2, ',', '.') }}
                                                        @break

                                                        @default
                                                            {{ $record->data[$field->field_name] }}
                                                    @endswitch
                                                </td>
                                            @endforeach
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#updateModal-{{ $record->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal-{{ $record->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="deleteModal-{{ $record->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus catatan ini? Tindakan ini tidak dapat
                                                        dibatalkan.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('records.delete', $record) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Ubah -->
                                        <div class="modal fade" id="updateModal-{{ $record->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Ubah Catatan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('records.update', $record->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="update-month-{{ $record->id }}"
                                                                    class="form-label">Bulan</label>
                                                                <select name="month" id="update-month-{{ $record->id }}"
                                                                    class="form-select" required>
                                                                    @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
                                                                        <option value="{{ $month }}"
                                                                            {{ $record->month == $month ? 'selected' : '' }}>
                                                                            {{ $month }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            @foreach ($table->fields as $field)
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="update-{{ $field->field_name }}-{{ $record->id }}"
                                                                        class="form-label">{{ $field->field_name }}</label>
                                                                    <input type="{{ $field->field_type }}"
                                                                        id="update-{{ $field->field_name }}-{{ $record->id }}"
                                                                        name="{{ $field->field_name }}"
                                                                        value="{{ $record->data[$field->field_name] ?? '' }}"
                                                                        class="form-control" required>
                                                                </div>
                                                            @endforeach

                                                            <div class="d-grid">
                                                                <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Simpan Perubahan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="{{ count($table->fields) + 2 }}" class="text-center">Tidak ada
                                                catatan ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk menampilkan toast
            function showToast(message, type = 'success') {
                const toastContainer = document.createElement('div');
                toastContainer.style.position = 'fixed';
                toastContainer.style.top = '20px';
                toastContainer.style.right = '20px';
                toastContainer.style.zIndex = '1050';

                const toastElement = document.createElement('div');
                toastElement.classList.add('toast', 'show', `bg-${type}`, 'text-white');
                toastElement.setAttribute('role', 'alert');
                toastElement.setAttribute('aria-live', 'assertive');
                toastElement.setAttribute('aria-atomic', 'true');

                const toastBody = document.createElement('div');
                toastBody.classList.add('toast-body');
                toastBody.textContent = message;

                toastElement.appendChild(toastBody);
                toastContainer.appendChild(toastElement);
                document.body.appendChild(toastContainer);

                setTimeout(() => {
                    toastElement.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(toastContainer);
                    }, 500);
                }, 3000);
            }

            // Menangani pesan sukses
            const successMessage = '{{ session('success') }}';
            if (successMessage) {
                showToast(successMessage);
            }

            // Animasi untuk card
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('animate-fade-in');
            });

            // Menangani submit form
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitButton = this.querySelector('button[type="submit"]');
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                });
            });

            // Menangani scroll tabel
            const tableContainer = document.querySelector('.table-responsive');
            if (tableContainer) {
                tableContainer.addEventListener('scroll', function() {
                    const header = document.querySelector('thead');
                    header.style.transform = `translateY(${this.scrollTop}px)`;
                });
            }
        });
    </script>
</body>
</html>