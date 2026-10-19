<?php 
include_once "../src/koneksi.php"; 

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';

$query = $koneksi->query("SELECT * FROM kategori_pelanggan WHERE id_kategori = '$id'");
$data = $query->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data kategori tidak ditemukan!'); window.location='halaman_admin.php?open=data_kategori';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $diskon        = intval($_POST['diskon']);

    $update = $koneksi->query("UPDATE kategori_pelanggan SET nama_kategori = '$nama_kategori', diskon = $diskon WHERE id_kategori = '$id'");

    if ($update) {
        echo "<script>alert('Kategori berhasil diperbarui!'); window.location='halaman_admin.php?open=data_kategori';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui kategori!');</script>";
    }
}
?>

<style>
    .form-container { width: 100%; max-width: 750px; margin: 0 auto; }
    .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .form-icon { width: 48px; height: 48px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #60a5fa; }
    .form-header h2 { margin: 0; color: var(--text-main); font-size: 1.45rem; font-weight: 600; }
    .form-header p { margin: 4px 0 0; color: var(--text-muted); font-size: 0.85rem; }
    .form-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; padding: 30px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; color: var(--text-main); font-size: 0.85rem; font-weight: 600; }
    .form-control { width: 100%; height: 45px; box-sizing: border-box; padding: 0 14px; border-radius: 9px; border: 1px solid var(--border-color); background: #181c2a; color: var(--text-main); outline: none; font-size: 0.88rem; transition: 0.2s ease; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1); }
    .form-control:disabled { opacity: 0.6; cursor: not-allowed; }
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
            <i data-feather="edit-2"></i>
        </div>
        <div>
            <h2>Edit Kategori Pelanggan</h2>
            <p>Perbarui informasi nama kategori atau persentase diskon</p>
        </div>
    </div>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label>ID Kategori</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['id_kategori']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($data['nama_kategori']); ?>" required>
            </div>
            <div class="form-group">
                <label>Diskon (%)</label>
                <input type="number" name="diskon" class="form-control" value="<?= intval($data['diskon']); ?>" min="0" max="100" required>
            </div>
            <div class="form-actions">
                <button type="submit" name="update" class="btn-simpan">
                    <i data-feather="save" style="width:15px;"></i> Simpan Perubahan
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