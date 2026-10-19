<?php include_once "../src/koneksi.php"; ?>

<style>
    .kategori-container {
        width: 100%;
    }

    .kategori-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .kategori-title {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .kategori-icon {
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

    .kategori-title h2 {
        margin: 0;
        color: var(--text-main);
        font-size: 1.45rem;
        font-weight: 600;
    }

    .kategori-title p {
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

    .kategori-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .kategori-table thead {
        background: #181c2a;
    }

    .kategori-table th {
        padding: 16px 18px;
        text-align: left;
        color: var(--text-muted);
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--border-color);
    }

    .kategori-table td {
        padding: 16px 18px;
        color: var(--text-main);
        font-size: 0.88rem;
        border-bottom: 1px solid rgba(45, 55, 72, 0.65);
    }

    .kategori-table tbody tr {
        transition: 0.2s ease;
    }

    .kategori-table tbody tr:hover {
        background: rgba(243, 156, 18, 0.045);
    }

    .kategori-table tbody tr:last-child td {
        border-bottom: none;
    }

    .nomor {
        color: var(--text-muted);
        width: 60px;
    }

    .id-kategori {
        display: inline-block;
        padding: 5px 10px;
        background: rgba(243, 156, 18, 0.1);
        color: var(--primary);
        border: 1px solid rgba(243, 156, 18, 0.2);
        border-radius: 7px;
        font-weight: 600;
        font-size: 0.78rem;
    }

    .nama-kategori {
        font-weight: 500;
    }

    .diskon {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        background: rgba(34, 197, 94, 0.1);
        color: #4ade80;
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
        .kategori-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-tambah {
            width: 100%;
            justify-content: center;
        }

        .kategori-table th,
        .kategori-table td {
            padding: 13px 14px;
        }
    }
</style>

<div class="kategori-container">

    <div class="kategori-header">

        <div class="kategori-title">
            <div class="kategori-icon">
                <i data-feather="users"></i>
            </div>

            <div>
                <h2>Data Kategori Pelanggan</h2>
                <p>Kelola kategori dan diskon pelanggan</p>
            </div>
        </div>

        <a href="halaman_admin.php?open=tambah_kategori" class="btn-tambah">
            <i data-feather="plus"></i>
            Tambah Kategori
        </a>

    </div>


    <div class="table-card">

        <div class="table-wrapper">

            <table class="kategori-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Diskon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <?php
                    $sql = "SELECT * FROM kategori_pelanggan ORDER BY id_kategori ASC";
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
                            <span class="id-kategori">
                                <?= htmlspecialchars($row['id_kategori']); ?>
                            </span>
                        </td>

                        <td class="nama-kategori">
                            <?= htmlspecialchars($row['nama_kategori']); ?>
                        </td>

                        <td>
                            <span class="diskon">
                                <?= htmlspecialchars($row['diskon']); ?>%
                            </span>
                        </td>

                        <td>

                            <div class="aksi">

                                <a
                                    href="halaman_admin.php?open=edit_kategori&id=<?= $row['id_kategori']; ?>"
                                    class="btn-aksi btn-edit"
                                >
                                    <i data-feather="edit-2" style="width:14px;"></i>
                                    Edit
                                </a>

                                <a
                                    href="hapus_kategori.php?id=<?= $row['id_kategori']; ?>"
                                    class="btn-aksi btn-hapus"
                                    onclick="return confirm('Yakin ingin menghapus kategori ini?')"
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
                        <td colspan="5" class="empty-data">

                            <div class="empty-icon">
                                <i data-feather="folder-open"></i>
                            </div>

                            Belum ada data kategori pelanggan.

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

