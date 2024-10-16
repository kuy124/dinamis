<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Landing Page</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .background {
            background: linear-gradient(138deg, #8000ff, #0059ff);
            background-size: 300% 300%;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            overflow: hidden;
            animation: gradientAnimation 5s ease-in-out infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 50% 50%;
            }
        }

        .content-box { 
            margin-top: 4rem;
            padding: 10px;
            border-radius: 15px;
            max-width: 600px;
            transition: all 0.3s ease-in-out;
        }


        .title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .description {
            font-size: 1.2rem;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .btn-custom {
            background-color: #ffffff;
            color: 8000ff;
            padding: 10px 25px;
            border-radius: 10px;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin: 10px;
        }

        .btn-custom:hover {
            background-color: #8000ff
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .navbar-toggler {
            border: none;
        }

        .navbar {
            background-color: #f8f9fa; 
            text-align: left;
        }

        .navbar-toggler {
            border: none; 
        }

        .offcanvas-header {
            background-color: #8000ff; 
            color: #ffffff;
        }

        .offcanvas-body {
            background-color: #ffffff; 
        }


        .nav-link {
            color: #343a40; 
            transition: color 0.3s ease; 
            font-size: large;
        }

        .nav-link:hover {
            color: #8000ff; 
        }

        .nav-link.active {
            color: #8000ff;
        }

        /* Ubah warna tombol X */
        .btn-close {
            background-color: white;
            border: none;
            filter: invert(1); /* Mengubah warna X menjadi putih, cocok untuk background gelap */
            width: 1.25rem;
            height: 1.25rem;
        }

        .toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            justify-content: flex-end;
            z-index: 1050;
        }

        .toast {
            margin-bottom: 10px;
            border: none;
        }

        @media (max-width: 576px) {
            .toast-container {
                top: 50%;
                left: 50%;
                transform: translate(-50%, 240%);
                justify-content: center;
                right: auto;
                bottom: auto;
                position: fixed;
                z-index: 1050;
            }
        }
    </style>
</head>
<body>
    <div class="particle-container"></div>

    <div class="background">
        <div class="content-box">
            <h2 class="title">ASTIK SUDIN KOMINFOTIK</h2>
            <p class="description">Selamat Datang di <strong>Website Dashboard</strong></p>
            <a href="{{ url('user') }}" class="btn btn-custom">Dashboard</a>
            <a href="{{ route('login') }}" class="btn btn-custom">Login Admin</a>
        </div>

        <nav class="navbar bg-body-tertiary fixed-top">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"></a>
              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Jelajahi</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                      <a class="nav-link" aria-current="page" href="{{ url('user') }}">Dashboard User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ url('index') }}">Dashboard Admin</a>
                      </li>
                    <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kontak') }}">Kontak</a>
                      </li>
                  </ul>
                  <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
                </div>
              </div>
            </div>
        </nav>

        <div class="toast-container">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">SMKN 64 JAKARTA</strong>
                    <small>23 Detik lalu</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" style="color: black;">
                    Welcome, Develop By SMKN 64 Jakarta.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const offcanvasNavbar = document.querySelector('#offcanvasNavbar');
            const navbarLinks = document.querySelectorAll('.offcanvas-body .nav-link');
    
            navbarLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    if (this.classList.contains('dropdown-toggle')) {
                        return;
                    }
                    const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasNavbar);
                    offcanvas.hide();
                });
            });
    
            offcanvasNavbar.addEventListener('hide.bs.offcanvas', function () {
                document.body.classList.remove('offcanvas-open');
                const backdrop = document.querySelector('.offcanvas-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        });
    
        window.onload = function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
    
            const toastElList = Array.from(document.querySelectorAll('.toast'));
            const toastList = toastElList.map(toastEl => new bootstrap.Toast(toastEl, {
                delay: 2000
            }));
    
            toastList.forEach(toast => toast.show());
        };
    </script>
    
</body>
</html>
