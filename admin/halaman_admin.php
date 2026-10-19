<?php
session_start();
// Cek apakah sudah login (aktifkan jika sudah ada sistem login)
// if (!isset($_SESSION['level']) || $_SESSION['level'] == "") {
//     header("location:../index.php?pesan=gagal");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Rental Kamera</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        :root {
            --primary: #f39c12;
            --bg-dark: #0f111a;
            --bg-sidebar: #181b28;
            --bg-card: #1e2233;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border-color: #2d3748;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; text-decoration: none; outline: none; }
        body { background-color: var(--bg-dark); color: var(--text-main); display: flex; min-height: 100vh; }

        /* SIDEBAR KIRI */
        .sidebar { width: 260px; background-color: var(--bg-sidebar); border-right: 1px solid var(--border-color); display: flex; flex-direction: column; position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 20px; font-size: 1.3rem; font-weight: 700; color: #fff; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 10px; }
        .sidebar-brand span { color: var(--primary); }
        .sidebar-profile { padding: 20px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid var(--border-color); background: rgba(255, 255, 255, 0.02); }
        .sidebar-profile img { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary); }
        .sidebar-profile .user-info .username { font-size: 0.9rem; font-weight: 600; color: #fff; }
        .sidebar-profile .user-info .role { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; }
        
        .sidebar-menu { list-style: none; padding: 15px 10px; flex: 1; overflow-y: auto; }
        .sidebar-menu li { margin-bottom: 8px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 12px; padding: 12px 15px; color: var(--text-muted); font-weight: 500; font-size: 0.95rem; border-radius: 8px; transition: all 0.3s ease; }
        .sidebar-menu a:hover, .sidebar-menu a.active { background-color: var(--primary); color: #fff; }

        /* KONTEN UTAMA */
        .main-content { margin-left: 260px; flex: 1; display: flex; flex-direction: column; padding: 30px; }
        .card-container { background-color: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); min-height: 85vh; overflow-x: auto; }

        /* PENGATURAN TEKS & TABEL */
        h2 { color: #fff; margin-bottom: 20px; font-weight: 600; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; color: var(--text-main); }
        table th, table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--border-color); font-size: 0.9rem; }
        table th { background-color: rgba(255,255,255,0.03); color: var(--primary); font-weight: 600; }
        table tr:hover { background-color: rgba(255,255,255,0.02); }

        /* TAMBAHAN UNTUK FITUR BARU: Tombol, Badge, & Grid Card */
        .header-action { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .btn { display: inline-flex; align-items: center; gap: 5px; padding: 8px 15px; border-radius: 6px; color: #fff; font-size: 0.85rem; font-weight: 500; border: none; cursor: pointer; transition: 0.3s; }
        .btn-primary { background: var(--primary); }
        .btn-primary:hover { background: #d68910; }
        .btn-success { background: #10b981; }
        .btn-success:hover { background: #059669; }
        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; }
        
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background: rgba(16, 185, 129, 0.15); color: #10b981; }
        .badge-warning { background: rgba(245, 158, 11, 0.15); color: #f59e0b; }
        .badge-danger { background: rgba(239, 68, 68, 0.15); color: #ef4444; }

        .grid-cards { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--bg-sidebar); padding: 20px; border-radius: 10px; border-left: 4px solid var(--primary); box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .stat-card h3 { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 5px; font-weight: 400; border: none; }
        .stat-card p { font-size: 1.8rem; font-weight: bold; color: #fff; margin: 0; }

        /* Responsif */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar .sidebar-brand span, .sidebar-profile .user-info, .sidebar-menu span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <i data-feather="camera"></i>
            <div>Rental<span>Cam</span></div>
        </div>

        <div class="sidebar-profile">
            <img src="https://i.pinimg.com/1200x/4f/8d/c7/4f8dc7015f1648c436c9ab804697b7c3.jpg" alt="Avatar">
            <div class="user-info">
                <div class="username"><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Administrator'; ?></div>
                <div class="role"><?php echo isset($_SESSION['level']) ? strtoupper($_SESSION['level']) : 'ADMIN'; ?></div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li><a href="halaman_admin.php?open=informasi_utama"><i data-feather="home"></i> <span>Dashboard</span></a></li>
            <li><a href="halaman_admin.php?open=data_petugas"><i data-feather="user-check"></i> <span>Petugas</span></a></li>
            <li><a href="halaman_admin.php?open=data_kategori"><i data-feather="tag"></i> <span>Data Kategori</span></a></li>
            <li><a href="halaman_admin.php?open=data_kamera"><i data-feather="box"></i> <span>Data Kamera</span></a></li>
            <li><a href="halaman_admin.php?open=data_pelanggan"><i data-feather="users"></i> <span>Pelanggan</span></a></li>
            <li><a href="halaman_admin.php?open=data_transaksi"><i data-feather="shopping-cart"></i> <span>Transaksi</span></a></li>
            
            <!-- MENU REKAP BULANAN DITAMBAHKAN DI SINI -->
            <li><a href="halaman_admin.php?open=rekap_transaksi"><i data-feather="file-text"></i> <span>Rekap Bulanan</span></a></li>
            
            <li style="margin-top: 30px;"><a href="logout.php" onclick="return confirm('Yakin ingin keluar?')" style="color: #ef4444;"><i data-feather="log-out"></i> <span>Logout</span></a></li>
        </ul>
    </aside>

    <div class="main-content">
        <div class="card-container">
            <?php 
            if(isset($_GET['open'])){
                $page = $_GET['open'] . '.php';
                if(file_exists($page)){
                    include $page;
                } else {
                    echo "<h2>Error 404</h2><p>Halaman tidak ditemukan.</p>";
                }
            } else {
                include "informasi_utama.php"; 
            }
            ?>
        </div>
    </div>

    <script> feather.replace(); </script>
</body>
</html>