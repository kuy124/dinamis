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
            background-color: #e8f0fe;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 800px;
        }

        .card {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            border: none;
            background-color: #ffffff;
        }

        .card-title {
            color: #3a3a3a;
            font-weight: 700;
            font-size: 2.2rem;
        }

        .btn {
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            color: #5a5c69;
            border-color: #5a5c69;
        }

        .btn-outline-secondary:hover {
            color: #fff;
            background-color: #5a5c69;
            transform: translateY(-2px);
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e3e6f0;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
            background-color: #f8f9fc;
            border: 2px solid #e3e6f0;
            border-right: none;
        }

        .column-preview {
            font-size: 0.875em;
            color: #858796;
            margin-top: 5px;
        }

        .floating-action-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #fields .card {
            margin-bottom: 20px;
            border-left: 5px solid #4e73df;
        }

        .field-header {
            background-color: #f8f9fc;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            font-weight: 600;
            color: #4e73df;
        }

        .field-body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <div class="card animate-fade-in">
            <div class="card-body p-5">
                <h1 class="card-title text-center mb-5">
                    <i class="fas fa-table me-3 text-primary"></i>Buat Tabel Baru
                </h1>

                <a href="{{ url('index') }}" class="btn btn-outline-secondary mb-4">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>

                <div id="errorContainer"></div>

                <form id="tableForm" action="{{ route('tables.store') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="mb-4">
                        <label for="table_name" class="form-label">Nama Tabel</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-font"></i></span>
                            <input type="text" id="table_name" name="table_name" class="form-control" required
                                value="{{ old('table_name') }}" placeholder="Masukkan nama tabel">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                            <textarea id="description" name="description" class="form-control" rows="3" placeholder="Deskripsi singkat tentang tabel ini">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div id="fields" class="mb-4">
                        <h3 class="mb-3">Kolom</h3>
                        <!-- Kolom akan ditambahkan di sini -->
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-secondary" onclick="addField()">
                            <i class="fas fa-plus me-2"></i>Tambah Kolom
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Buat Tabel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <button class="btn btn-primary floating-action-button" onclick="addField()" title="Tambah Kolom Baru">
        <i class="fas fa-plus"></i>
    </button>

    <div class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let fieldCount = 0;

        function addField() {
            fieldCount++;
            const fieldsDiv = document.getElementById('fields');
            const fieldDiv = document.createElement('div');
            fieldDiv.className = 'card animate-fade-in';
            const uniqueId = Date.now();
            fieldDiv.innerHTML = `
                <div class="field-header">
                    Kolom #${fieldCount}
                </div>
                <div class="field-body">
                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Nama Kolom</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" name="fields[${uniqueId}][name]" class="form-control column-name" placeholder="Nama Kolom" required oninput="updatePreview(this)">
                            </div>
                            <div class="column-preview mt-1" id="preview-${uniqueId}"></div>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label">Tipe Kolom</label>
                            <select name="fields[${uniqueId}][type]" class="form-select" required>
                                <option value="" disabled selected>Pilih Tipe Kolom</option>
                                <option value="text">Teks</option>
                                <option value="number">Angka</option>
                                <option value="date">Tanggal</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            fieldsDiv.appendChild(fieldDiv);
            showToast('Kolom baru ditambahkan!', 'success');
        }

        function updatePreview(input) {
            const preview = input.closest('.col-md-5').querySelector('.column-preview');
            const formattedName = input.value.trim().replace(/\s+/g, '_');

            if (input.value.trim() === "") {
                preview.textContent = "";
            } else {
                preview.innerHTML = `<i class="fas fa-info-circle me-1"></i>Kolom akan dinamakan: <strong>${formattedName}</strong>`;
            }
        }

        function removeField(button) {
            const fieldCard = button.closest('.card');
            fieldCard.style.animation = 'fadeOut 0.3s ease-in-out';
            setTimeout(() => {
                fieldCard.remove();
                fieldCount--;
                showToast('Kolom dihapus!', 'warning');
            }, 300);
        }

        function validateForm() {
            const tableNameInput = document.getElementById('table_name');
            const tableName = tableNameInput.value.trim();
            const errorContainer = document.getElementById('errorContainer');
            errorContainer.innerHTML = '';

            if (tableName === '') {
                showError('Nama tabel harus diisi.');
                return false;
            }

            if (fieldCount === 0) {
                showError('Tambahkan setidaknya satu kolom untuk tabel.');
                return false;
            }

            return true;
        }

        function showError(message) {
            const errorContainer = document.getElementById('errorContainer');
            errorContainer.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        }

        function showToast(message, type = 'info') {
            const toastContainer = document.querySelector('.toast-container');
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Menghapus pemanggilan addField() saat halaman dimuat
        // document.addEventListener('DOMContentLoaded', function() {
        //     addField();
        // });
    </script>
</body>

</html>