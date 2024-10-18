<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: #1a73e8;
            --secondary-color: #34a853;
            --background-color: #f8f9fa;
            --card-color: #ffffff;
            --text-color: #202124;
            --accent-color: #ea4335;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .sidebar {
            background-color: var(--primary-color);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            padding-top: 20px;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            padding: 10px 20px;
            font-size: 1rem;
        }

        .sidebar-menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar-menu li a:hover, 
        .sidebar-menu li a:focus {
            color: rgb(0, 5, 158); /* Ganti dengan warna yang Anda inginkan */
        }

        .sidebar-menu li a i {
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .dashboard-header {
            background-color: var(--card-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .stats-card {
            background-color: var(--card-color);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .stats-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stats-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-color);
        }

        .table-card {
            background-color: var(--card-color);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-left: 5px solid var(--primary-color);
        }

        .btn-action {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 15px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-action:hover {
            background-color: #1967d2;
            transform: translateY(-2px);
        }

        .btn-floating {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--secondary-color);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }

        .btn-floating:hover {
            background-color: #2d9249;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            .sidebar-header h3, .sidebar-menu li span {
                display: none;
            }
            .main-content {
                margin-left: 70px;
            }
        }

        .fade-out {
            animation: fadeOut 3s forwards;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Dashboard</h3>
        </div>
        <ul class="sidebar-menu">
            <li><a href="#"><i class="fas fa-home"></i> <span>Home</span></a></li>
            <li><a href="{{ route('login') }}"><i class="fa-solid fa-arrow-right-to-bracket"></i> <span>Login</span></a></li>
            <li><a href="{{ route('charts') }}"><i class="fas fa-chart-bar"></i> <span>Grafik</span></a></li>
            <li><a href="{{ url('/') }}"><i class="fa-solid fa-arrow-right-to-bracket fa-flip-horizontal"></i> <span>Kembali</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="dashboard-header">
            <h1><i class="fas fa-tachometer-alt me-3"></i>Dashboard User</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-out" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="stats-card text-center">
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h3 class="stats-title">Total Tabel</h3>
                    <div class="stats-value">{{ count($tables) }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card text-center">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="stats-title">Admin</h3>
                    <div class="stats-value">{{ DB::table('users')->count() }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stats-card text-center">
                    <div class="stats-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                    <h3 class="stats-title">Tanggal</h3>
                    <div id="current-date" class="stats-value"></div>
                </div>
            </div>
        </div>

        <h2 class="mb-4">Daftar Tabel</h2>
        <div class="row">
            @forelse($tables as $table)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="table-card">
                        <h5 class="card-title"><i class="fas fa-table me-2"></i>{{ $table->table_name }}</h5>
                        <p class="card-text">{{ $table->description }}</p>
                        <a href="{{ route('user.show', $table) }}" class="btn btn-action">
                            <i class="fas fa-eye me-2"></i>Lihat Tabel
                        </a>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

            function formatDate(date) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                return date.toLocaleDateString('id-ID', options);
            }

            document.getElementById('current-date').textContent = formatDate(new Date());
        });
    </script>
</body>

</html>