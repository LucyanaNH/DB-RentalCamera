<?php include_once "../src/koneksi.php"; ?>

<style>
    .petugas-container { width: 100%; }
    .petugas-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 15px; }
    .petugas-title { display: flex; align-items: center; gap: 14px; }
    .petugas-icon { width: 48px; height: 48px; background: rgba(243, 156, 18, 0.12); border: 1px solid rgba(243, 156, 18, 0.25); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); }
    .petugas-title h2 { margin: 0; color: var(--text-main); font-size: 1.45rem; font-weight: 600; }
    .petugas-title p { margin: 4px 0 0; color: var(--text-muted); font-size: 0.85rem; }
    .btn-tambah { display: inline-flex; align-items: center; gap: 8px; padding: 11px 17px; border-radius: 10px; background: var(--primary); color: #111827; text-decoration: none; font-weight: 600; font-size: 0.88rem; transition: 0.2s ease; box-shadow: 0 4px 12px rgba(243, 156, 18, 0.18); }
    .btn-tambah:hover { transform: translateY(-2px); box-shadow: 0 7px 18px rgba(243, 156, 18, 0.28); color: #111827; }
    .table-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
    .table-wrapper { width: 100%; overflow-x: auto; }
    .petugas-table { width: 100%; border-collapse: collapse; min-width: 800px; }
    .petugas-table thead { background: #181c2a; }
    .petugas-table th { padding: 16px 18px; text-align: left; color: var(--text-muted); font-size: 0.78rem; font-weight: 600; text-transform: uppercase; border-bottom: 1px solid var(--border-color); }
    .petugas-table td { padding: 16px 18px; color: var(--text-main); font-size: 0.88rem; border-bottom: 1px solid rgba(45, 55, 72, 0.65); }
    .petugas-table tbody tr:hover { background: rgba(243, 156, 18, 0.045); }
    .id-petugas { display: inline-block; padding: 5px 10px; background: rgba(243, 156, 18, 0.1); color: var(--primary); border: 1px solid rgba(243, 156, 18, 0.2); border-radius: 7px; font-weight: 600; font-size: 0.78rem; }
    .badge-level { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: capitalize; }
    .badge-admin { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .badge-petugas { background: rgba(16, 185, 129, 0.15); color: #10b981; }
    .aksi-container { display: flex; align-items: center; gap: 8px; }
    .btn-edit, .btn-hapus { display: inline-flex; align-items: center; justify-content: center; gap: 5px; padding: 7px 11px; border-radius: 8px; text-decoration: none; font-size: 0.76rem; font-weight: 600; transition: 0.2s ease; }
    .btn-edit { background: rgba(59, 130, 246, 0.12); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
    .btn-hapus { background: rgba(239, 68, 68, 0.12); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
    .empty-data { text-align: center !important; padding: 45px 20px !important; color: var(--text-muted) !important; }
</style>

<div class="petugas-container">
    <div class="petugas-header">
        <div class="petugas-title">
            <div class="petugas-icon">
                <i data-feather="user-check"></i>
            </div>
            <div>
                <h2>Data Petugas / Admin</h2>
                <p>Kelola akun petugas dan administrator sistem</p>
            </div>
        </div>
        <a href="halaman_admin.php?open=tambah_petugas" class="btn-tambah">
            <i data-feather="plus"></i> Tambah Petugas
        </a>
    </div>

    <div class="table-card">
        <div class="table-wrapper">
            <table class="petugas-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Petugas</th>
                        <th>Username</th>
                        <th>Nama Petugas</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM petugas ORDER BY id_petugas ASC";
                    $result = $koneksi->query($query);

                    if ($result && $result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td style="color: var(--text-muted);"><?= $no++; ?></td>
                        <td><span class="id-petugas"><?= htmlspecialchars($row['id_petugas']); ?></span></td>
                        <td><?= htmlspecialchars($row['username']); ?></td>
                        <td style="font-weight: 500;"><?= htmlspecialchars($row['nama_petugas']); ?></td>
                        <td>
                            <span class="badge-level <?= ($row['level'] == 'admin') ? 'badge-admin' : 'badge-petugas'; ?>">
                                <?= htmlspecialchars($row['level']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="aksi-container">
                                <a href="halaman_admin.php?open=edit_petugas&id=<?= $row['id_petugas']; ?>" class="btn-edit">
                                    <i data-feather="edit-2" style="width:14px;"></i> Edit
                                </a>
                                <a href="hapus_petugas.php?id=<?= $row['id_petugas']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus petugas ini?');">
                                    <i data-feather="trash-2" style="width:14px;"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='empty-data'>Belum ada data petugas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    if (typeof feather !== 'undefined') { feather.replace(); }
</script>