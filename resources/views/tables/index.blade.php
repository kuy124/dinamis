<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-header {
            background-color: #4e73df;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        .dashboard-title {
            font-weight: 700;
            font-size: 2.5rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }


        .card-header {
            background-color: #4e73df;
            color: white;
            border-bottom: none;
            padding: 15px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .card-header i {
            font-size: 20px;
            margin-right: 10px;
        }

        .card-body {
            padding: 15px;
            background-color: white;
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
        }

        .btn-floating-chart {
            bottom: 100px;
            /* Position it above the add button */
        }

        .fade-out {
            animation: fadeOut 3s forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .table-stats {
            background-color: #36b9cc;
            color: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px;
            transition: all 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .table-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .stats-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .stats-title {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .stats-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .btn-action {
            border-radius: 20px;
            padding: 8px 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        #current-date {
            font-size: 1.2rem;
            font-weight: bold;
            margin-top: 5px;
        }

        .logout-btn {
            position: absolute;
            top: 12px;
            right: 20px;
            background-color: #dc3545;
            /* Solid red on hover */
            color: white;
            border-color: #dc3545;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background-color: #dc3545;
            /* Solid red on hover */
            color: white;
            border-color: #dc3545;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
            transform: translateY(-2px);
        }

        .logout-btn i {
            margin-right: 8px;
            font-size: 1rem;
        }

        @media (max-width: 576px) {
            .logout-btn {
                top: 10px;
                right: 10px;
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .logout-btn i {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 767px) {
            .table-stats {
                margin-bottom: 15px;
            }

            .stats-icon {
                font-size: 2rem;
            }

            .stats-title {
                font-size: 0.9rem;
            }

            .stats-value {
                font-size: 1.2rem;
            }

            #current-date {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <header class="dashboard-header">
        <div class="container position-relative">
            <h1 class="dashboard-title"><i class="fas fa-table me-3"></i>Dashboard</h1>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            <a href="#" class="logout-btn"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>

        </div>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-out" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">Dashboard</button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="table-stats">
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="stats-title">Total Tabel</h3>
                    <div class="stats-value">{{ count($tables) }}</div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="table-stats">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stats-title">Admin</h3>
                    <div class="stats-value">
                        {{ DB::table('users')->count() }}
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="table-stats">
                    <div class="stats-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3 class="stats-title">Tanggal Hari Ini</h3>
                    <div id="current-date" class="stats-value"></div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            @forelse($tables as $table)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                            <h5 class="mb-0">{{ $table->table_name }}</h5>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <p class="card-description flex-grow-1">{{ $table->description }}</p>
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('tables.show', $table) }}" class="btn btn-primary btn-action">
                                    <i class="fas fa-eye me-2"></i>Lihat Tabel
                                </a>
                                <button type="button" class="btn btn-danger btn-action" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal-{{ $table->id }}">
                                    <i class="fas fa-trash-alt me-2"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus -->
                <div class="modal fade" id="deleteModal-{{ $table->id }}" tabindex="-1"
                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus tabel "<strong>{{ $table->table_name }}</strong>" dan
                                semua catatannya? Tindakan ini tidak dapat dibatalkan.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form action="{{ route('tables.destroy', $table) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada tabel ditemukan. Mulailah dengan membuat tabel baru!
                    </div>
                </div>
            @endforelse
        </div>

        @if ($tables->isNotEmpty())
            <a href="{{ route('charts') }}" class="btn btn-success btn-lg btn-floating btn-floating-chart">
                <i class="fas fa-chart-bar"></i>
            </a>
        @endif
    </div>

    <a href="{{ route('tables.create') }}" class="btn btn-primary btn-lg btn-floating">
        <i class="fas fa-plus"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function formatDate(date) {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return date.toLocaleDateString('id-ID', options);
        }

        document.getElementById('current-date').textContent = formatDate(new Date());

        // Auto-hide success alert after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alertElement = document.querySelector('.alert-success');
                if (alertElement) {
                    alertElement.classList.add('fade');
                    setTimeout(function() {
                        alertElement.remove();
                    }, 500);
                }
            }, 3000);
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
