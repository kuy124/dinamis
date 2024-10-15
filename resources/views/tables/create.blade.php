<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Tabel Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-floating {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 100;
        }

        .column-preview {
            font-size: 0.875em;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center text-primary mb-4">Buat Tabel Baru</h1>

                <a href="{{ url('index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>

                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('tables.store') }}" method="POST" onsubmit="replaceSpaces()">
                    @csrf
                    <div class="mb-3">
                        <label for="table_name" class="form-label">Nama Tabel</label>
                        <input type="text" id="table_name" name="table_name" class="form-control" required
                            value="{{ old('table_name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div id="fields">
                        <h3 class="mb-3">Kolom</h3>
                    </div>

                    <button type="button" class="btn btn-secondary mb-3" onclick="addField()">
                        <i class="fas fa-plus me-2"></i>Tambah Kolom
                    </button>
                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="fas fa-save me-2"></i>Buat Tabel
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addField() {
            const fieldsDiv = document.getElementById('fields');
            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'card mb-3';
            const uniqueId = Date.now(); // Unique ID for fields
            fieldDiv.innerHTML = `
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-2">
                            <label class="form-label">Nama Kolom</label>
                            <input type="text" name="fields[${uniqueId}][name]" class="form-control column-name" placeholder="Nama Kolom" required oninput="updatePreview(this)">
                            <div class="column-preview" id="preview-${uniqueId}"></div>
                        </div>
                        <div class="col-md-5 mb-2">
                            <label class="form-label">Tipe Kolom</label>
                            <select name="fields[${uniqueId}][type]" class="form-select" required>
                                <option value="" disabled selected>Pilih Tipe Kolom</option>
                                <option value="text">Teks</option>
                                <option value="number">Angka</option>
                                <option value="date">Tanggal</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end mb-2">
                            <button type="button" class="btn btn-danger" onclick="this.closest('.card').remove()">
                                <i class="fas fa-trash-alt me-2"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>
            `;
            fieldsDiv.appendChild(fieldDiv);
        }

        function updatePreview(input) {
            const preview = input.nextElementSibling;
            const formattedName = input.value.trim().replace(/\s+/g, '_');

            if (input.value.trim() === "") {
                preview.textContent = "";
            } else {
                preview.textContent = `Kolom akan dinamakan: ${formattedName}`;
            }
        }


        function replaceSpaces() {
            const columnNames = document.querySelectorAll('.column-name');
            columnNames.forEach(input => {
                input.value = input.value.trim().replace(/\s+/g, '_');
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            addField();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
