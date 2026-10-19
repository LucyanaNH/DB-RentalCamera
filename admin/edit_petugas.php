<?php 
include_once "../src/koneksi.php"; 

$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';
$query = $koneksi->query("SELECT * FROM petugas WHERE id_petugas = '$id'");
$data = $query->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data petugas tidak ditemukan!'); window.location='halaman_admin.php?open=data_petugas';</script>";
    exit();
}

if (isset($_POST['update'])) {
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama_petugas = mysqli_real_escape_string($koneksi, $_POST['nama_petugas']);
    $level        = mysqli_real_escape_string($koneksi, $_POST['level']);

    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $sql = "UPDATE petugas SET username='$username', password='$password', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id'";
    } else {
        $sql = "UPDATE petugas SET username='$username', nama_petugas='$nama_petugas', level='$level' WHERE id_petugas='$id'";
    }

    if ($koneksi->query($sql)) {
        echo "<script>alert('Data petugas berhasil diperbarui!'); window.location='halaman_admin.php?open=data_petugas';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>

<style>
    .form-container { width: 100%; max-width: 750px; margin: 0 auto; }
    .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .form-icon { width: 48px; height: 48px; background: rgba(59, 130, 246, 0.12); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #60a5fa; }
    .form-header h2 { margin: 0; color: var(--text-main); font-size: 1.45rem; font-weight: 600; }
    .form-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; padding: 30px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; color: var(--text-main); font-size: 0.85rem; font-weight: 600; }
    .form-control { width: 100%; height: 45px; box-sizing: border-box; padding: 0 14px; border-radius: 9px; border: 1px solid var(--border-color); background: #181c2a; color: var(--text-main); outline: none; font-size: 0.88rem; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1); }
    .form-control:disabled { opacity: 0.6; cursor: not-allowed; }
    .form-actions { display: flex; gap: 10px; margin-top: 30px; }
    .btn-simpan, .btn-batal { display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 10px 18px; border-radius: 9px; text-decoration: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; }
    .btn-simpan { border: none; background: var(--primary); color: #111827; }
    .btn-batal { background: rgba(148, 163, 184, 0.08); border: 1px solid var(--border-color); color: var(--text-muted); }
</style>

<div class="form-container">
    <div class="form-header">
        <div class="form-icon"><i data-feather="edit-2"></i></div>
        <div>
            <h2>Edit Petugas</h2>
            <p>Perbarui informasi akun petugas atau administrator</p>
        </div>
    </div>

    <div class="form-card">
        <form method="POST">
            <div class="form-group">
                <label>ID Petugas</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($data['id_petugas']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Password Baru <small style="color: var(--text-muted);">(Kosongkan jika tidak ingin mengubah password)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru jika ingin mengubah">
            </div>
            <div class="form-group">
                <label>Nama Petugas</label>
                <input type="text" name="nama_petugas" class="form-control" value="<?= htmlspecialchars($data['nama_petugas']); ?>" required>
            </div>
            <div class="form-group">
                <label>Level</label>
                <select name="level" class="form-control" required>
                    <option value="admin" <?= ($data['level'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    <option value="petugas" <?= ($data['level'] == 'petugas') ? 'selected' : ''; ?>>Petugas</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" name="update" class="btn-simpan"><i data-feather="save" style="width:15px;"></i> Simpan Perubahan</button>
                <a href="halaman_admin.php?open=data_petugas" class="btn-batal"><i data-feather="arrow-left" style="width:15px;"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
<script>if (typeof feather !== 'undefined') { feather.replace(); }</script>