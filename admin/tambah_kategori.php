<?php include_once "../src/koneksi.php"; ?>

<style>
    .form-container { width: 100%; max-width: 750px; margin: 0 auto; }
    .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .form-icon { width: 48px; height: 48px; background: rgba(243, 156, 18, 0.12); border: 1px solid rgba(243, 156, 18, 0.25); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); }
    .form-header h2 { margin: 0; color: var(--text-main); font-size: 1.45rem; font-weight: 600; }
    .form-header p { margin: 4px 0 0; color: var(--text-muted); font-size: 0.85rem; }
    .form-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; padding: 30px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; color: var(--text-main); font-size: 0.85rem; font-weight: 600; }
    .form-control { width: 100%; height: 45px; box-sizing: border-box; padding: 0 14px; border-radius: 9px; border: 1px solid var(--border-color); background: #181c2a; color: var(--text-main); outline: none; font-size: 0.88rem; transition: 0.2s ease; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1); }
    .form-actions { display: flex; gap: 10px; margin-top: 30px; }
    .btn-simpan, .btn-batal { display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 10px 18px; border-radius: 9px; text-decoration: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: 0.2s ease; }
    .btn-simpan { border: none; background: var(--primary); color: #111827; }
    .btn-simpan:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(243, 156, 18, 0.2); }
    .btn-batal { background: rgba(148, 163, 184, 0.08); border: 1px solid var(--border-color); color: var(--text-muted); }
    .btn-batal:hover { background: rgba(148, 163, 184, 0.14); color: var(--text-main); }
</style>

<div class="form-container">
    <div class="form-header">
        <div class="form-icon">
            <i data-feather="plus-circle"></i>
        </div>
        <div>
            <h2>Tambah Kategori Pelanggan</h2>
            <p>Tambahkan jenis kategori baru beserta besaran diskonnya</p>
        </div>
    </div>

    <?php
    if (isset($_POST['simpan'])) {
        $id_kategori   = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
        $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
        $diskon        = intval($_POST['diskon']);

        $sql = "INSERT INTO kategori_pelanggan (id_kategori, nama_kategori, diskon) VALUES ('$id_kategori', '$nama_kategori', $diskon)";
        
        if ($koneksi->query($sql)) {
            echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='halaman_admin.php?open=data_kategori';</script>";
            exit();
        } else {
            echo "<script>alert('Gagal menambahkan kategori: " . addslashes($koneksi->error) . "');</script>";
        }
    }
    ?>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label>ID Kategori</label>
                <input type="text" name="id_kategori" class="form-control" placeholder="Contoh: KAT03" required>
            </div>
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Gold / Reseller" required>
            </div>
            <div class="form-group">
                <label>Diskon (%)</label>
                <input type="number" name="diskon" class="form-control" placeholder="Contoh: 15" min="0" max="100" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="simpan" class="btn-simpan">
                    <i data-feather="save" style="width:15px;"></i> Simpan Kategori
                </button>
                <a href="halaman_admin.php?open=data_kategori" class="btn-batal">
                    <i data-feather="arrow-left" style="width:15px;"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    if (typeof feather !== 'undefined') { feather.replace(); }
</script>