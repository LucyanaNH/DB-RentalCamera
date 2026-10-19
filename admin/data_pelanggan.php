<?php include_once "../src/koneksi.php"; ?>

<style>
    .pelanggan-container {
        width: 100%;
    }

    .pelanggan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .pelanggan-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .pelanggan-icon {
        width: 48px;
        height: 48px;
        background: rgba(243, 156, 18, 0.12);
        border: 1px solid rgba(243, 156, 18, 0.25);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .pelanggan-title h2 {
        margin: 0;
        color: var(--text-main);
        font-size: 1.45rem;
        font-weight: 600;
    }

    .pelanggan-title p {
        margin: 4px 0 0;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 17px;
        border-radius: 10px;
        background: var(--primary);
        color: #111827;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.88rem;
        transition: 0.2s ease;
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.18);
    }

    .btn-tambah:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 18px rgba(243, 156, 18, 0.28);
        color: #111827;
    }

    .table-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .pelanggan-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px;
    }

    .pelanggan-table thead {
        background: #181c2a;
    }

    .pelanggan-table th {
        padding: 16px 18px;
        text-align: left;
        color: var(--text-muted);
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }

    .pelanggan-table td {
        padding: 16px 18px;
        color: var(--text-main);
        font-size: 0.88rem;
        border-bottom: 1px solid rgba(45, 55, 72, 0.65);
    }

    .pelanggan-table tbody tr {
        transition: 0.2s ease;
    }

    .pelanggan-table tbody tr:hover {
        background: rgba(243, 156, 18, 0.045);
    }

    .pelanggan-table tbody tr:last-child td {
        border-bottom: none;
    }

    .nomor {
        color: var(--text-muted);
        width: 60px;
    }

    .id-pelanggan {
        display: inline-block;
        padding: 5px 10px;
        background: rgba(243, 156, 18, 0.1);
        color: var(--primary);
        border: 1px solid rgba(243, 156, 18, 0.2);
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.78rem;
    }

    .nik-text {
        font-family: monospace;
        letter-spacing: 0.5px;
        color: #e2e8f0;
    }

    .nama-pelanggan {
        font-weight: 500;
    }

    .alamat-text {
        color: var(--text-muted);
        font-size: 0.82rem;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .telepon {
        color: var(--text-muted);
    }

    .kategori-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        background: rgba(243, 156, 18, 0.1);
        color: var(--primary);
        border: 1px solid rgba(243, 156, 18, 0.18);
        font-size: 0.76rem;
        font-weight: 600;
    }

    .diskon {
        color: #4ade80;
        margin-left: 3px;
    }

    /* =========================
        BUTTON EDIT & HAPUS
        ========================= */

    .aksi-container {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit,
    .btn-hapus {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 11px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.76rem;
        font-weight: 600;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .btn-edit {
        background: rgba(59, 130, 246, 0.12);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .btn-edit:hover {
        background: rgba(59, 130, 246, 0.2);
        transform: translateY(-1px);
    }

    .btn-hapus {
        background: rgba(239, 68, 68, 0.12);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-hapus:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: translateY(-1px);
    }

    .btn-edit i,
    .btn-hapus i {
        width: 14px;
        height: 14px;
    }

    .empty-data {
        text-align: center !important;
        padding: 45px 20px !important;
        color: var(--text-muted) !important;
    }

    .empty-icon {
        width: 50px;
        height: 50px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: rgba(148, 163, 184, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
    }

    @media (max-width: 700px) {
        .pelanggan-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-tambah {
            width: 100%;
            justify-content: center;
        }

        .pelanggan-table th,
        .pelanggan-table td {
            padding: 13px 14px;
        }

        .aksi-container {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-edit,
        .btn-hapus {
            width: 75px;
        }
    }
</style>


<div class="pelanggan-container">

    <!-- HEADER -->
    <div class="pelanggan-header">
        <div class="pelanggan-title">
            <div class="pelanggan-icon">
                <i data-feather="users"></i>
            </div>
            <div>
                <h2>Data Pelanggan</h2>
                <p>Daftar member dan pelanggan rental kamera</p>
            </div>
        </div>

        <!-- TOMBOL TAMBAH -->
        <a href="halaman_admin.php?open=tambah_pelanggan" class="btn-tambah">
            <i data-feather="plus"></i> Tambah Pelanggan
        </a>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <div class="table-wrapper">
            <table class="pelanggan-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pelanggan</th>
                        <th>NIK</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No. Telp</th>
                        <th>Kategori / Diskon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT 
                                p.id_pelanggan,
                                p.nik,
                                p.nama_pelanggan,
                                p.alamat,
                                p.no_telp,
                                k.id_kategori,
                                k.nama_kategori,
                                k.diskon
                              FROM pelanggan p
                              INNER JOIN kategori_pelanggan k ON p.id_kategori = k.id_kategori
                              ORDER BY p.id_pelanggan ASC";

                    $result = $koneksi->query($query);

                    if ($result && $result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <!-- NOMOR -->
                        <td class="nomor">
                            <?= $no++; ?>
                        </td>

                        <!-- ID PELANGGAN -->
                        <td>
                            <span class="id-pelanggan">
                                <?= htmlspecialchars($row['id_pelanggan']); ?>
                            </span>
                        </td>

                        <!-- NIK -->
                        <td>
                            <span class="nik-text">
                                <?= htmlspecialchars($row['nik']); ?>
                            </span>
                        </td>

                        <!-- NAMA -->
                        <td class="nama-pelanggan">
                            <?= htmlspecialchars($row['nama_pelanggan']); ?>
                        </td>

                        <!-- ALAMAT -->
                        <td class="alamat-text" title="<?= htmlspecialchars($row['alamat']); ?>">
                            <?= htmlspecialchars($row['alamat']); ?>
                        </td>

                        <!-- TELEPON -->
                        <td class="telepon">
                            <?= htmlspecialchars($row['no_telp']); ?>
                        </td>

                        <!-- KATEGORI -->
                        <td>
                            <span class="kategori-badge">
                                <i data-feather="tag" style="width:13px;"></i>
                                <?= htmlspecialchars($row['nama_kategori']); ?>
                                <span class="diskon">
                                    <?= htmlspecialchars($row['diskon']); ?>%
                                </span>
                            </span>
                        </td>

                        <!-- AKSI -->
                        <td>
                            <div class="aksi-container">
                                <!-- EDIT -->
                                <a href="halaman_admin.php?open=edit_pelanggan&id=<?= $row['id_pelanggan']; ?>" class="btn-edit">
                                    <i data-feather="edit-2"></i> Edit
                                </a>

                                <!-- HAPUS -->
                                <a href="hapus_pelanggan.php?id=<?= $row['id_pelanggan']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus pelanggan ini?');">
                                    <i data-feather="trash-2"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                    <!-- DATA KOSONG -->
                    <tr>
                        <td colspan="8" class="empty-data">
                            <div class="empty-icon">
                                <i data-feather="users"></i>
                            </div>
                            Belum ada data pelanggan.
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>