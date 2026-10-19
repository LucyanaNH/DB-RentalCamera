<?php include_once "../src/koneksi.php"; ?>

<style>
    .kamera-container {
        width: 100%;
    }

    .kamera-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .kamera-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .kamera-icon {
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

    .kamera-title h2 {
        margin: 0;
        color: var(--text-main);
        font-size: 1.45rem;
        font-weight: 600;
    }

    .kamera-title p {
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

    .kamera-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .kamera-table thead {
        background: #181c2a;
    }

    .kamera-table th {
        padding: 16px 18px;
        text-align: left;
        color: var(--text-muted);
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }

    .kamera-table td {
        padding: 14px 18px;
        color: var(--text-main);
        font-size: 0.88rem;
        border-bottom: 1px solid rgba(45, 55, 72, 0.65);
    }

    .kamera-table tbody tr {
        transition: 0.2s ease;
    }

    .kamera-table tbody tr:hover {
        background: rgba(243, 156, 18, 0.045);
    }

    .kamera-table tbody tr:last-child td {
        border-bottom: none;
    }

    .nomor {
        color: var(--text-muted);
        width: 55px;
    }

    .gambar-kamera {
        width: 70px;
        height: 50px;
        object-fit: cover;
        border-radius: 9px;
        border: 1px solid var(--border-color);
        display: block;
    }

    .gambar-kosong {
        width: 70px;
        height: 50px;
        border-radius: 9px;
        background: rgba(148, 163, 184, 0.08);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
    }

    .id-kamera {
        display: inline-block;
        padding: 5px 10px;
        background: rgba(243, 156, 18, 0.1);
        color: var(--primary);
        border: 1px solid rgba(243, 156, 18, 0.2);
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.78rem;
    }

    .nama-kamera {
        font-weight: 500;
    }

    .merk-kamera {
        color: var(--text-muted);
    }

    .tarif {
        color: var(--primary);
        font-weight: 600;
    }

    .stok-tersedia {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(34, 197, 94, 0.1);
        color: #4ade80;
        font-weight: 600;
        font-size: 0.78rem;
    }

    .stok-habis {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        font-weight: 600;
        font-size: 0.78rem;
    }

    .aksi {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .btn-aksi {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 11px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 0.76rem;
        font-weight: 600;
        transition: 0.2s ease;
    }

    .btn-edit {
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .btn-edit:hover {
        background: rgba(59, 130, 246, 0.18);
        transform: translateY(-1px);
    }

    .btn-hapus {
        background: rgba(239, 68, 68, 0.1);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-hapus:hover {
        background: rgba(239, 68, 68, 0.18);
        transform: translateY(-1px);
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
        .kamera-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-tambah {
            width: 100%;
            justify-content: center;
        }

        .kamera-table th,
        .kamera-table td {
            padding: 13px 14px;
        }
    }
</style>

<div class="kamera-container">

<div class="kamera-header">

    <div class="kamera-title">

        <div class="kamera-icon">
            <i data-feather="camera"></i>
        </div>

        <div>
            <h2>Data Kamera</h2>
            <p>Kelola inventaris dan tarif kamera rental</p>
        </div>

    </div>

    <a href="halaman_admin.php?open=tambah_kamera" class="btn-tambah">
        <i data-feather="plus"></i>
        Tambah Kamera
    </a>

</div>


<div class="table-card">

    <div class="table-wrapper">

        <table class="kamera-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>ID Kamera</th>
                    <th>Nama Kamera</th>
                    <th>Merk</th>
                    <th>Tarif / Hari</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                <?php
                $sql = "SELECT * FROM kamera ORDER BY id_kamera ASC";
                $result = $koneksi->query($sql);

                if ($result->num_rows > 0) {

                    $no = 1;

                    while ($row = $result->fetch_assoc()) {
                ?>

                <tr>

                    <td class="nomor">
                        <?= $no++; ?>
                    </td>


                    <td>

                        <?php if (!empty($row['gambar'])) { ?>

                            <img
                                src="<?= htmlspecialchars($row['gambar']); ?>"
                                alt="Kamera"
                                class="gambar-kamera"
                            >

                        <?php } else { ?>

                            <div class="gambar-kosong">
                                <i data-feather="camera" style="width:20px;"></i>
                            </div>

                        <?php } ?>

                    </td>


                    <td>

                        <span class="id-kamera">
                            <?= htmlspecialchars($row['id_kamera']); ?>
                        </span>

                    </td>


                    <td class="nama-kamera">
                        <?= htmlspecialchars($row['nama_kamera']); ?>
                    </td>


                    <td class="merk-kamera">
                        <?= htmlspecialchars($row['merk']); ?>
                    </td>


                    <td class="tarif">

                        Rp <?= number_format(
                            $row['tarif_per_hari'],
                            0,
                            ',',
                            '.'
                        ); ?>

                    </td>


                    <td>

                        <?php if ($row['stok'] > 0) { ?>

                            <span class="stok-tersedia">
                                <?= htmlspecialchars($row['stok']); ?> Unit
                            </span>

                        <?php } else { ?>

                            <span class="stok-habis">
                                Habis
                            </span>

                        <?php } ?>

                    </td>


                    <td>

                        <div class="aksi">

                            <a
                                href="halaman_admin.php?open=edit_kamera&id=<?= $row['id_kamera']; ?>"
                                class="btn-aksi btn-edit"
                            >
                                <i data-feather="edit-2" style="width:14px;"></i>
                                Edit
                            </a>


                            <a
                                href="hapus_kamera.php?id=<?= $row['id_kamera']; ?>"
                                class="btn-aksi btn-hapus"
                                onclick="return confirm('Yakin ingin menghapus kamera ini?')"
                            >
                                <i data-feather="trash-2" style="width:14px;"></i>
                                Hapus
                            </a>

                        </div>

                    </td>

                </tr>

                <?php
                    }

                } else {
                ?>

                <tr>

                    <td colspan="8" class="empty-data">

                        <div class="empty-icon">
                            <i data-feather="camera-off"></i>
                        </div>

                        Belum ada data kamera.

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
