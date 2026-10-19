<?php 
include_once "../src/koneksi.php"; 

// Ambil ID pelanggan dari parameter URL (menggunakan string escape karena ID berupa string seperti P001)
$id = isset($_GET['id']) ? mysqli_real_escape_string($koneksi, $_GET['id']) : '';


// =====================================
// AMBIL DATA PELANGGAN
// =====================================

$query = mysqli_query(
    $koneksi,
    "SELECT *
     FROM pelanggan
     WHERE id_pelanggan = '$id'"
);

$data = mysqli_fetch_assoc($query);


// Jika pelanggan tidak ditemukan
if (!$data) {
    echo "<p style='color:red; padding: 20px;'>Data pelanggan tidak ditemukan.</p>";
    exit;
}


// =====================================
// PROSES UPDATE
// =====================================

if (isset($_POST['update'])) {

    $nik = mysqli_real_escape_string(
        $koneksi,
        $_POST['nik']
    );

    $nama_pelanggan = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_pelanggan']
    );

    $alamat = mysqli_real_escape_string(
        $koneksi,
        $_POST['alamat']
    );

    $no_telp = mysqli_real_escape_string(
        $koneksi,
        $_POST['no_telp']
    );

    $id_kategori = mysqli_real_escape_string(
        $koneksi,
        $_POST['id_kategori']
    );


    // =====================================
    // CEK APAKAH KATEGORI ADA
    // =====================================

    $cek_kategori = mysqli_query(
        $koneksi,
        "SELECT id_kategori
         FROM kategori_pelanggan
         WHERE id_kategori = '$id_kategori'"
    );


    if (!$cek_kategori || mysqli_num_rows($cek_kategori) == 0) {

        echo "<script>
            alert('Kategori pelanggan tidak ditemukan! Silakan pilih kategori yang tersedia.');
            window.location='halaman_admin.php?open=edit_pelanggan&id=$id';
        </script>";

        exit;
    }


    // =====================================
    // UPDATE DATA
    // =====================================

    $update = mysqli_query(
        $koneksi,
        "UPDATE pelanggan SET
            nik = '$nik',
            nama_pelanggan = '$nama_pelanggan',
            alamat = '$alamat',
            no_telp = '$no_telp',
            id_kategori = '$id_kategori'
         WHERE id_pelanggan = '$id'"
    );


    if ($update) {

        echo "<script>
            alert('Data pelanggan berhasil diperbarui!');
            window.location='halaman_admin.php?open=data_pelanggan';
        </script>";

        exit;

    } else {

        echo "<script>
            alert('Data pelanggan gagal diperbarui: " . addslashes($koneksi->error) . "');
            window.location='halaman_admin.php?open=data_pelanggan';
        </script>";

        exit;
    }
}


// =====================================
// AMBIL DATA KATEGORI
// =====================================

$kategori = mysqli_query(
    $koneksi,
    "SELECT *
     FROM kategori_pelanggan
     ORDER BY nama_kategori ASC"
);

?>


<style>

    .edit-pelanggan-container {
        max-width: 750px;
        margin: 0 auto;
    }

    .edit-header {
        margin-bottom: 25px;
    }

    .edit-header h2 {
        margin: 0;
        color: var(--text-main);
        font-size: 1.45rem;
        font-weight: 600;
    }

    .edit-header p {
        margin-top: 5px;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .form-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        color: var(--text-main);
        font-size: 0.85rem;
        font-weight: 600;
    }

    .form-control, .form-textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border-radius: 9px;
        border: 1px solid var(--border-color);
        background: #181c2a;
        color: var(--text-main);
        outline: none;
        font-size: 0.88rem;
        transition: 0.2s ease;
        font-family: inherit;
    }

    .form-control {
        height: 45px;
    }

    .form-textarea {
        resize: vertical;
        min-height: 90px;
    }

    .form-control:focus, .form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1);
    }

    .form-control:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .info-id {
        margin-top: 6px;
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

    .btn-simpan,
    .btn-batal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 16px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-simpan {
        border: none;
        background: var(--primary);
        color: #111827;
    }

    .btn-simpan:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(243, 156, 18, 0.2);
    }

    .btn-batal {
        background: rgba(148, 163, 184, 0.08);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
    }

    .btn-batal:hover {
        background: rgba(148, 163, 184, 0.14);
        color: var(--text-main);
    }

</style>


<div class="edit-pelanggan-container">

    <!-- HEADER -->
    <div class="edit-header">
        <h2>Edit Pelanggan</h2>
        <p>Perbarui informasi data pelanggan rental kamera.</p>
    </div>

    <!-- FORM -->
    <div class="form-card">
        <form method="POST">

            <!-- ID PELANGGAN -->
            <div class="form-group">
                <label>ID Pelanggan</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($data['id_pelanggan']); ?>"
                    disabled
                >
                <div class="info-id">ID pelanggan tidak dapat diubah.</div>
            </div>

            <!-- NIK -->
            <div class="form-group">
                <label>NIK</label>
                <input
                    type="text"
                    name="nik"
                    class="form-control"
                    value="<?= htmlspecialchars($data['nik']); ?>"
                    placeholder="Masukkan 16 digit NIK"
                    required
                >
            </div>

            <!-- NAMA -->
            <div class="form-group">
                <label>Nama Pelanggan</label>
                <input
                    type="text"
                    name="nama_pelanggan"
                    class="form-control"
                    value="<?= htmlspecialchars($data['nama_pelanggan']); ?>"
                    placeholder="Masukkan nama lengkap"
                    required
                >
            </div>

            <!-- ALAMAT (TAMBAHAN BARU) -->
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <textarea
                    name="alamat"
                    class="form-textarea"
                    placeholder="Masukkan alamat domisili"
                    required
                ><?= htmlspecialchars($data['alamat']); ?></textarea>
            </div>

            <!-- NO TELEPON -->
            <div class="form-group">
                <label>No. Telp</label>
                <input
                    type="text"
                    name="no_telp"
                    class="form-control"
                    value="<?= htmlspecialchars($data['no_telp']); ?>"
                    placeholder="Contoh: 081234567890"
                    required
                >
            </div>

            <!-- KATEGORI -->
            <div class="form-group">
                <label>Kategori Pelanggan</label>
                <select
                    name="id_kategori"
                    class="form-control"
                    required
                >
                    <option value="">-- Pilih Kategori --</option>
                    <?php
                    if ($kategori && mysqli_num_rows($kategori) > 0) {
                        while ($kat = mysqli_fetch_assoc($kategori)) {
                    ?>
                        <option
                            value="<?= $kat['id_kategori']; ?>"
                            <?= ($kat['id_kategori'] == $data['id_kategori']) ? 'selected' : ''; ?>
                        >
                            <?= htmlspecialchars($kat['nama_kategori']); ?> - Diskon <?= htmlspecialchars($kat['diskon']); ?>%
                        </option>
                    <?php
                        }
                    } else {
                    ?>
                        <option value="">Belum ada kategori pelanggan</option>
                    <?php } ?>
                </select>
            </div>

            <!-- BUTTON -->
            <div class="form-actions">
                <button type="submit" name="update" class="btn-simpan">
                    <i data-feather="save" style="width:15px;"></i> Simpan Perubahan
                </button>
                <a href="halaman_admin.php?open=data_pelanggan" class="btn-batal">
                    <i data-feather="arrow-left" style="width:15px;"></i> Batal
                </a>
            </div>

        </form>
    </div>

</div>

<script>
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>