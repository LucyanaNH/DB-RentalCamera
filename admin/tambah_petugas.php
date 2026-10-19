<?php 
include_once "../src/koneksi.php"; 

if (isset($_POST['simpan'])) {
    $id_petugas   = mysqli_real_escape_string($koneksi, $_POST['id_petugas']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password     = md5($_POST['password']); 
    $nama_petugas = mysqli_real_escape_string($koneksi, $_POST['nama_petugas']);
    $level        = mysqli_real_escape_string($koneksi, $_POST['level']);

    $sql = "INSERT INTO petugas (id_petugas, username, password, nama_petugas, level) 
            VALUES ('$id_petugas', '$username', '$password', '$nama_petugas', '$level')";

    if ($koneksi->query($sql)) {
        echo "<script>alert('Petugas berhasil ditambahkan!'); window.location='halaman_admin.php?open=data_petugas';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal: " . addslashes($koneksi->error) . "');</script>";
    }
}
?>

<style>
    .form-container { width: 100%; max-width: 750px; margin: 0 auto; }
    .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
    .form-icon { width: 48px; height: 48px; background: rgba(243, 156, 18, 0.12); border: 1px solid rgba(243, 156, 18, 0.25); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary); }
    .form-header h2 { margin: 0; color: var(--text-main); font-size: 1.45rem; font-weight: 600; }
    .form-card { background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 14px; padding: 30px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; color: var(--text-main); font-size: 0.85rem; font-weight: 600; }
    .form-control { width: 100%; height: 45px; box-sizing: border-box; padding: 0 14px; border-radius: 9px; border: 1px solid var(--border-color); background: #181c2a; color: var(--text-main); outline: none; font-size: 0.88rem; }
    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1); }
    .form-actions { display: flex; gap: 10px; margin-top: 30px; }
    .btn-simpan, .btn-batal { display: inline-flex; align-items: center; justify-content: center; gap: 7px; padding: 10px 18px; border-radius: 9px; text-decoration: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; }
    .btn-simpan { border: none; background: var(--primary); color: #111827; }
    .btn-batal { background: rgba(148, 163, 184, 0.08); border: 1px solid var(--border-color); color: var(--text-muted); }
</style>

<div class="form-container">
    <div class="form-header">
        <div class="form-icon"><i data-feather="user-plus"></i></div>
        <div>
            <h2>Tambah Petugas Baru</h2>
            <p>Daftarkan akun administrator atau petugas rental baru</p>
        </div>
    </div>

 <div class="form-card">
        <form method="POST" autocomplete="off"> <!-- Tambahkan autocomplete="off" di sini -->
            <div class="form-group">
                <label>ID Petugas</label>
                <input type="text" name="id_petugas" class="form-control" placeholder="Contoh: PET02" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username login" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <!-- Gunakan autocomplete="new-password" agar browser tidak mengisi otomatis password lama -->
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" autocomplete="new-password" required>
            </div>
            <div class="form-group">
                <label>Nama Petugas</label>
                <input type="text" name="nama_petugas" class="form-control" placeholder="Nama lengkap petugas" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label>Level</label>
                <select name="level" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="submit" name="simpan" class="btn-simpan"><i data-feather="save" style="width:15px;"></i> Simpan Petugas</button>
                <a href="halaman_admin.php?open=data_petugas" class="btn-batal"><i data-feather="arrow-left" style="width:15px;"></i> Batal</a>
            </div>
        </form>
    </div>
</div>
<script>if (typeof feather !== 'undefined') { feather.replace(); }</script>