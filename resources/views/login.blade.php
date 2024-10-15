<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .background {
            background: linear-gradient(138deg, #8000ff, #2d38ff);
            background-size: 300% 300%;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            overflow: hidden;
            animation: gradientAnimation 10s ease-in-out infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 50% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .content-box {
            background-color: #fff;
            color: #333;
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            width: 100%;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            text-align: left;
        }

        .content-box:hover {
            transform: scale(1.03);
        }

        .title {
            font-size: 2rem;
            font-weight: 600;
            color: #8000ff;
            margin-bottom: 15px;
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #8000ff;
            box-shadow: none;
        }

        /* Tombol login dengan warna mencolok dan efek hover */
        .btn-custom {
            background-color: #8000ff;
            color: white;
            border-radius: 10px;
            padding: 10px 25px;
            font-size: 1.1rem;
            width: 100%;
            border: none;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(64, 0, 147, 0.3);
            margin-top: 20px;
        }

        .btn-custom:hover {
            background-color: #5600ac;
            box-shadow: 0 5px 15px rgba(59, 0, 132, 0.5);
            transform: scale(1.02);
        }

        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .back-button a {
            color: #8000ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-button a:hover {
            color: #8000ff;
        }

        .alert {
            background-color: #ff4757;
            color: white;
            border-radius: 12px;
            padding: 15px;
            font-size: 1rem;
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="background">
        <div class="content-box">
            <div class="title">Login</div>
            
            <!-- Display error messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required autofocus>
                </div>
                <div class="form-group password-wrapper">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <i class="fa fa-eye" id="eyeIcon"></i>
                    </span>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="showPassword"> Show Password
                </div>
                
                <!-- Tombol Login dengan warna mencolok -->
                <button type="submit" class="btn btn-primary btn-custom">Login</button>
            </form>
            
            <div class="back-button">
                <a href="{{ url('/') }}">Kembali</a>
            </div>
            

    <script>
        document.getElementById('showPassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            if (this.checked) {
                passwordField.type = 'text';  // Ubah input menjadi teks untuk melihat password
            } else {
                passwordField.type = 'password';  // Ubah kembali menjadi password
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
