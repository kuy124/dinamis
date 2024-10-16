<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex; /* Flexbox untuk memposisikan kartu di tengah */
            align-items: center; /* Vertikal */
            justify-content: center; /* Horizontal */
            height: 100vh; /* Memastikan body memiliki tinggi penuh */
        }

        .container {
            max-width: 1200px;
            width: 100%; /* Memastikan kontainer tidak lebih lebar dari 100% */
            margin: 20px; /* Memberikan sedikit ruang di semua sisi */
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            padding-bottom: 50px;
        }

        .card-body {
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .col-md-6 {
            flex: 1;
            min-width: 400px;
        }

        .col-md-6.map {
            flex: 2;
        }

        h5 {
            margin-top: 0;
            font-size: 1.8em; /* Ukuran font diperbesar */
        }

        p {
            line-height: 1.6;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 5px;
        }

        ul li a {
            color: #007bff;
            text-decoration: none;
        }

        ul li a:hover {
            text-decoration: underline;
        }

        .map-container {
            position: relative;
            width: 100%;
            padding-bottom: 65%;
        }

        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        /* Style for the back button */
        .back-button {
            position: absolute;
            bottom: 10px;
            left: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 1em;
        }

        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Informasi Kontak</h5> <!-- Judul kontak lebih besar -->
                    <p>Email: <a href="mailto:astikkominfojaktim@jsclab.id">astikkominfojaktim@jsclab.id</a></p>
                    <p>No. Telp: +62 896-3690-9084</p>
                    <p>Alamat: <b>Sudin Kominfotik Jakarta Timur</b>
                        Blok B1 lantai 3 Kantor Wali Kota Jakarta Timur RT.11, RT.11/RW.8, Pulo Gebang, Cakung, Kota Jakarta Timur, Jakarta 13950</p>
                    <p>Ikuti Kami di:</p>
                    <ul>
                        <li><a href="https://www.facebook.com/share/p5zYJENEKwbkmtTK/">Facebook</a></li>
                        <li><a href="https://www.youtube.com/@SudinKominfotikJakartaTimur">YouTube</a></li>
                        <li><a href="https://www.instagram.com/kotajakartatimur?igsh=YW9vcjk1YW1nYnJx">Instagram</a></li>
                    </ul>
                </div>
                <div class="col-md-6 map">
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.375639028955!2d106.94159487499026!3d-6.214090693773825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698d70059c8b3f%3A0x207cb9a26106d5f9!2sSudin%20Kominfotik%20Jakarta%20Timur!5e0!3m2!1sid!2sid!4v1729042655580!5m2!1sid!2sid" 
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>  
                </div>
            </div>
        </div>
        <!-- Back button at the bottom-left corner -->
        <a href="{{ url('/') }}" class="back-button">Back</a>
    </div>
</div>

</body>
</html>
