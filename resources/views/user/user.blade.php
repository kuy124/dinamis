<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

        /* .table-stats:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        } */

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

        .logout-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.5);
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            margin: 2rem;
        }
        .logout-btn:hover {
            background-color: white;
            color: #4e73df;
            border-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
    </style>
</head>

<body>
    <header class="dashboard-header">
        <div class="container">
            <h1 class="display-4"><i class="fas fa-table me-3"></i>Dashboard</h1>
            <a href="/" class="btn btn-light btn-sm logout-btn mt-3">
                <i class="fas fa-sign-out-alt me-2"></i>Kembali
            </a>
        </div>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-out" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                            <a href="{{ route('user.show', $table) }}" class="btn btn-primary btn-action">
                                <i class="fas fa-eye me-2"></i>Lihat Tabel
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        Tidak ada tabel ditemukan.
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Add hover effect to cards
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px)';
                card.style.boxShadow = '0 12px 20px rgba(0, 0, 0, 0.2)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        });
    </script>
</body>

</html>
