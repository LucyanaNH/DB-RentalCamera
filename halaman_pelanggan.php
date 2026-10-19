<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Kamera Senja</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <style>
        :root {
            --primary: #f39c12; /* Warna aksen yang cocok untuk tema alat fotografi */
            --bg: #010101; /* Warna gelap mirip tutorial WPU */
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg);
            color: #fff;
        }
        
        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.4rem 7%;
            background-color: rgba(1, 1, 1, 0.8);
            border-bottom: 1px solid #333;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
        }
        .navbar .navbar-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
        }
        .navbar .navbar-logo span {
            color: var(--primary);
        }
        .navbar .navbar-nav a {
            color: #fff;
            display: inline-block;
            font-size: 1.1rem;
            margin: 0 1rem;
        }
        .navbar .navbar-nav a:hover {
            color: var(--primary);
        }
        
        /* HERO SECTION */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1080&q=80');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero::after {
            content: '';
            display: block;
            position: absolute;
            width: 100%;
            height: 40%;
            bottom: 0;
            background: linear-gradient(0deg, rgba(1,1,1,1) 8%, rgba(255,255,255,0) 50%);
        }
        .hero .content {
            padding: 1.4rem 7%;
            max-width: 60rem;
            z-index: 1;
        }
        .hero .content h1 {
            font-size: 4em;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(1,1,3,0.5);
            line-height: 1.2;
        }
        .hero .content h1 span {
            color: var(--primary);
        }
        .hero .content p {
            font-size: 1.2rem;
            margin-top: 1rem;
            line-height: 1.4;
            font-weight: 300;
            text-shadow: 1px 1px 3px rgba(1,1,3,0.5);
        }
        .hero .content .cta {
            margin-top: 2rem;
            display: inline-block;
            padding: 1rem 3rem;
            font-size: 1.2rem;
            color: #fff;
            background-color: var(--primary);
            border-radius: 0.5rem;
            box-shadow: 1px 1px 3px rgba(1,1,3,0.5);
            transition: 0.3s;
        }
        .hero .content .cta:hover {
            background-color: #d68910;
        }

        /* SECTION TITLES */
        .kamera h2, .contact h2 {
            text-align: center;
            font-size: 2.6rem;
            margin-bottom: 2rem;
            padding-top: 8rem;
        }
        .kamera h2 span, .contact h2 span {
            color: var(--primary);
        }

        /* KATALOG KAMERA */
        .kamera {
            padding: 2rem 7% 5rem;
        }
        .kamera .row {
            display: flex;
            flex-wrap: wrap;
            margin-top: 3rem;
            justify-content: center;
            gap: 2rem;
        }
        
        /* Modifikasi Interaksi Kartu Kamera */
        .kamera-link {
            text-decoration: none;
            color: inherit;
        }
        .kamera-card {
            text-align: center;
            background: #111;
            border-radius: 1rem;
            padding: 2rem;
            width: 300px;
            border: 1px solid #222;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .kamera-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(243, 156, 18, 0.2);
            border-color: var(--primary);
        }
        .kamera-card img {
            border-radius: 1rem;
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 1.5rem;
        }
        .kamera-card .kamera-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        .kamera-card .kamera-merk {
            font-size: 1rem;
            color: #aaa;
            margin-bottom: 1rem;
        }
        .kamera-card .kamera-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
        }
        /* Tombol Sewa di dalam Card */
        .btn-sewa {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 20px;
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
            border-radius: 5px;
            font-weight: 600;
            transition: 0.3s;
        }
        .kamera-card:hover .btn-sewa {
            background-color: var(--primary);
            color: #fff;
        }

        /* FOOTER */
        footer {
            background-color: var(--primary);
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        footer .socials {
            margin-bottom: 1rem;
        }
        footer .socials a {
            color: #fff;
            margin: 0 1rem;
        }
        footer .socials a:hover {
            color: var(--bg);
        }
        footer .credit {
            font-size: 0.9rem;
            font-weight: 400;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">Rental<span>Kamera</span>.</a>
        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#katalog">Katalog Kamera</a>
            <a href="#contact">Kontak</a>
            <!-- Link menuju halaman login admin -->
            <a href="index.php" style="color: var(--primary); font-weight: bold;">Login Admin</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <main class="content">
            <h1>Abadikan Momen <span>Terbaikmu</span></h1>
            <p>Sewa kamera mirrorless dan DSLR terbaik dengan tarif harian yang terjangkau. Dapatkan diskon khusus bagi Anda yang tergabung dalam member <b>VIP</b>!</p>
            <a href="#katalog" class="cta">Sewa Sekarang</a>
        </main>
    </section>

    <!-- Katalog Section -->
    <section id="katalog" class="kamera">
        <h2><span>Katalog</span> Kamera</h2>
        <p style="text-align: center; max-width: 600px; margin: auto; font-weight: 300;">Pilihan alat fotografi dan videografi profesional terbaik untuk mendukung hasil karya Anda.</p>
        
        <div class="row">
            <!-- Kamera 1 (KAM001) -->
            <a href="halaman_pelanggan.php?id_kamera=KAM001" class="kamera-link">
                <div class="kamera-card">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500&q=80" alt="Sony Alpha A7 III">
                    <h3 class="kamera-title">Sony Alpha A7 III</h3>
                    <p class="kamera-merk">Sony (Stok Tersedia)</p>
                    <p class="kamera-price">Tarif Sesuai Database</p>
                    <span class="btn-sewa">Sewa Sekarang</span>
                </div>
            </a>
            
            <!-- Kamera 2 (KAM002) -->
            <a href="halaman_pelanggan.php?id_kamera=KAM002" class="kamera-link">
                <div class="kamera-card">
                    <img src="https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=500&q=80" alt="Canon EOS R6">
                    <h3 class="kamera-title">Canon EOS R6</h3>
                    <p class="kamera-merk">Canon (Stok Tersedia)</p>
                    <p class="kamera-price">Tarif Sesuai Database</p>
                    <span class="btn-sewa">Sewa Sekarang</span>
                </div>
            </a>
            
            <!-- Kamera 3 (KAM003) -->
            <a href="halaman_pelanggan.php?id_kamera=KAM003" class="kamera-link">
                <div class="kamera-card">
                    <img src="https://images.unsplash.com/photo-1512790182412-b19e6d61b397?w=500&q=80" alt="Fujifilm X-T4">
                    <h3 class="kamera-title">Fujifilm X-T4</h3>
                    <p class="kamera-merk">Fujifilm (Stok Tersedia)</p>
                    <p class="kamera-price">Tarif Sesuai Database</p>
                    <span class="btn-sewa">Sewa Sekarang</span>
                </div>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="socials">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>
        <p class="credit">Dikelola oleh Petugas: <b>Lucy (Admin)</b> | &copy; 2026</p>
    </footer>

    <!-- Feather Icons Script -->
    <script>
        feather.replace();
    </script>
</body>
</html>