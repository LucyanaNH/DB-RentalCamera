<?php
// informasi_utama.php
include_once "../src/koneksi.php";

// 1. Ambil Total Stok Kamera dari tabel `kamera`
$q_kamera = $koneksi->query("SELECT SUM(stok) as total_stok, COUNT(id_kamera) as jml_jenis FROM kamera");
$d_kamera = $q_kamera->fetch_assoc();
$total_kamera_unit = $d_kamera['total_stok'] ?? 0;

// 2. Ambil Total Pelanggan dari tabel `pelanggan`
$q_pelanggan = $koneksi->query("SELECT COUNT(id_pelanggan) as total FROM pelanggan");
$total_pelanggan = $q_pelanggan->fetch_assoc()['total'] ?? 0;

// 3. Ambil Total Transaksi dari tabel `transaksi`
$q_transaksi = $koneksi->query("SELECT COUNT(id_transaksi) as total FROM transaksi");
$total_transaksi = $q_transaksi->fetch_assoc()['total'] ?? 0;

// 4. Ambil Total Pendapatan
// dari transaksi yang lunas / selesai
$q_pendapatan = $koneksi->query("SELECT SUM(total_harga + denda) as total FROM transaksi WHERE status_pembayaran = 'Lunas'");
$total_pendapatan = $q_pendapatan->fetch_assoc()['total'] ?? 0;

// Format pendapatan
$pendapatan_formatted = "Rp " . number_format($total_pendapatan, 0, ',', '.');
?>

<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .dashboard-header h2 {
        margin: 0;
        border: none;
        padding: 0;
        font-size: 1.6rem;
    }

    .dashboard-header p {
        color: var(--text-muted);
        font-size: 0.85rem;
        margin-top: 5px;
    }

    .date-box {
        background: rgba(243, 156, 18, 0.1);
        border: 1px solid rgba(243, 156, 18, 0.3);
        color: var(--primary);
        padding: 10px 15px;
        border-radius: 8px;
        font-size: 0.85rem;

        display: flex;
        align-items: center;
        gap: 6px;
    }

    .date-box i {
        width: 15px;
        height: 15px;
    }


    /* STATISTIK */

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 25px;
    }

    .dashboard-stat {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
    }

    .dashboard-stat::after {
        content: "";
        position: absolute;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(243, 156, 18, 0.08);
        right: -25px;
        top: -25px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: rgba(243, 156, 18, 0.12);
        color: var(--primary);

        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-title {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-top: 15px;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin-top: 3px;
    }

    .stat-desc {
        color: #10b981;
        font-size: 0.72rem;
        margin-top: 5px;
    }


    /* CONTENT */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .dashboard-box {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
    }

    .box-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .box-header h3 {
        color: #fff;
        font-size: 1rem;
        font-weight: 600;
    }

    .box-header a {
        color: var(--primary);
        font-size: 0.75rem;
    }


    /* TABLE */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
    }

    .dashboard-table th {
        color: var(--text-muted);
        font-size: 0.72rem;
        font-weight: 500;
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .dashboard-table td {
        padding: 13px 10px;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.78rem;
        color: #e2e8f0;
    }

    .camera-name {
        font-weight: 500;
        color: #fff;
    }

    .camera-code {
        color: var(--text-muted);
        font-size: 0.68rem;
        margin-top: 2px;
    }


    /* MENU CEPAT */

    .quick-menu {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .quick-item {
        padding: 16px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        color: var(--text-main);
        transition: 0.3s;

        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-item:hover {
        border-color: var(--primary);
        background: rgba(243, 156, 18, 0.06);
        transform: translateY(-2px);
    }

    .quick-item i {
        color: var(--primary);
    }

    .quick-item span {
        font-size: 0.78rem;
    }


    /* BADGE */

    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }

    .badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }

    .badge-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }


    /* RESPONSIVE */

    @media (max-width: 1000px) {

        .dashboard-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 600px) {

        .dashboard-header {
            align-items: flex-start;
            gap: 10px;
            flex-direction: column;
        }

        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-box {
            overflow-x: auto;
        }

        .dashboard-table {
            min-width: 500px;
        }
    }
</style>


<!-- HEADER -->

<div class="dashboard-header">

    <div>

        <h2>Dashboard</h2>

        <p>
            Selamat datang kembali, Administrator 
        </p>

    </div>

    <div class="date-box">

        <i data-feather="calendar"></i>

        <?php echo date("d M Y"); ?>

    </div>

</div>


<!-- STATISTIK -->

<div class="dashboard-stats">


    <!-- TOTAL KAMERA -->

    <div class="dashboard-stat">

        <div class="stat-icon">
            <i data-feather="camera"></i>
        </div>

        <div class="stat-title">
            Total Kamera
        </div>

        <div class="stat-number">
            <?php echo $total_kamera_unit; ?> Unit
        </div>

        <div class="stat-desc">
            ● <?php echo $d_kamera['jml_jenis'] ?? 0; ?> Jenis kamera
        </div>

    </div>


    <!-- TOTAL PELANGGAN -->

    <div class="dashboard-stat">

        <div class="stat-icon">
            <i data-feather="users"></i>
        </div>

        <div class="stat-title">
            Total Pelanggan
        </div>

        <div class="stat-number">
            <?php echo $total_pelanggan; ?>
        </div>

        <div class="stat-desc">
            Terdaftar di sistem
        </div>

    </div>


    <!-- TOTAL TRANSAKSI -->

    <div class="dashboard-stat">

        <div class="stat-icon">
            <i data-feather="shopping-cart"></i>
        </div>

        <div class="stat-title">
            Total Transaksi
        </div>

        <div class="stat-number">
            <?php echo $total_transaksi; ?>
        </div>

        <div class="stat-desc">
            Semua riwayat sewa
        </div>

    </div>


    <!-- PENDAPATAN -->

    <div class="dashboard-stat">

        <div class="stat-icon">
            <i data-feather="credit-card"></i>
        </div>

        <div class="stat-title">
            Pendapatan Lunas
        </div>

        <div
            class="stat-number"
            style="font-size: 1.2rem;"
        >
            <?php echo $pendapatan_formatted; ?>
        </div>

        <div class="stat-desc">
            Akumulasi pembayaran
        </div>

    </div>

</div>


<!-- BAGIAN BAWAH -->

<div class="dashboard-grid">


    <!-- TRANSAKSI TERBARU -->

    <div class="dashboard-box">

        <div class="box-header">

            <h3>
                Transaksi Terbaru
            </h3>

            <a href="halaman_admin.php?open=data_transaksi">
                Lihat Semua
            </a>

        </div>


        <div class="table-wrapper">

            <table class="dashboard-table">

                <thead>

                    <tr>

                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Kamera
                        </th>

                        <th>
                            Tanggal Sewa
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php

                /*
                 * Tetap menggunakan data yang sama.
                 * Perbaikan: $conn menjadi $koneksi.
                 */

                $q_trx_terbaru = $koneksi->query("
                    SELECT 
                        t.*, 
                        p.nama_pelanggan, 
                        k.nama_kamera, 
                        k.merk
                    FROM transaksi t

                    JOIN pelanggan p
                        ON t.id_pelanggan = p.id_pelanggan

                    JOIN kamera k
                        ON t.id_kamera = k.id_kamera

                    ORDER BY t.id_transaksi DESC
                    LIMIT 4
                ");


                if (
                    $q_trx_terbaru &&
                    $q_trx_terbaru->num_rows > 0
                ) {

                    while (
                        $row = $q_trx_terbaru->fetch_assoc()
                    ) {

                        $badge_class = 'badge-success';


                        if (
                            $row['status_sewa'] == 'Berjalan'
                        ) {

                            $badge_class = 'badge-warning';

                        }


                        if (
                            $row['status_sewa'] == 'Terlambat' ||
                            $row['status_sewa'] == 'Dibatalkan'
                        ) {

                            $badge_class = 'badge-danger';

                        }

                        ?>

                        <tr>

                            <td>

                                <div class="camera-name">

                                    <?php

                                    echo htmlspecialchars(
                                        $row['nama_pelanggan']
                                    );

                                    ?>

                                </div>

                                <div class="camera-code">

                                    <?php

                                    echo "TRX-" .
                                        str_pad(
                                            $row['id_transaksi'],
                                            3,
                                            '0',
                                            STR_PAD_LEFT
                                        );

                                    ?>

                                </div>

                            </td>


                            <td>

                                <?php

                                echo htmlspecialchars(
                                    $row['merk'] .
                                    " " .
                                    $row['nama_kamera']
                                );

                                ?>

                            </td>


                            <td>

                                <?php

                                echo date(
                                    'd M Y',
                                    strtotime(
                                        $row['tgl_sewa']
                                    )
                                );

                                ?>

                            </td>


                            <td>

                                <span
                                    class="badge <?php echo $badge_class; ?>"
                                >

                                    <?php

                                    echo htmlspecialchars(
                                        $row['status_sewa']
                                    );

                                    ?>

                                </span>

                            </td>

                        </tr>

                        <?php

                    }

                } else {

                    ?>

                    <tr>

                        <td
                            colspan="4"
                            style="
                                text-align:center;
                                color:var(--text-muted);
                                padding:25px;
                            "
                        >

                            Belum ada transaksi terbaru.

                        </td>

                    </tr>

                    <?php

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>


    <!-- MENU CEPAT -->

    <div class="dashboard-box">

        <div class="box-header">

            <h3>
                Menu Cepat
            </h3>

        </div>


        <div class="quick-menu">


            <a
                href="halaman_admin.php?open=data_kamera"
                class="quick-item"
            >

                <i data-feather="camera"></i>

                <span>
                    Data Kamera
                </span>

            </a>


            <a
                href="halaman_admin.php?open=data_pelanggan"
                class="quick-item"
            >

                <i data-feather="user-plus"></i>

                <span>
                    Pelanggan
                </span>

            </a>


            <a
                href="halaman_admin.php?open=data_kategori"
                class="quick-item"
            >

                <i data-feather="tag"></i>

                <span>
                    Kategori
                </span>

            </a>


            <a
                href="halaman_admin.php?open=data_transaksi"
                class="quick-item"
            >

                <i data-feather="file-text"></i>

                <span>
                    Transaksi
                </span>

            </a>


        </div>

    </div>

</div>


<script>
    feather.replace();
</script>
