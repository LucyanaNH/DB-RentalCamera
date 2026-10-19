<?php include_once "../src/koneksi.php"; ?>

<style>
    .form-container {
        width: 100%;
        max-width: 850px;
        margin: 0 auto;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 28px;
    }

    .form-icon {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;

        background: rgba(243, 156, 18, 0.10);
        border: 1px solid rgba(243, 156, 18, 0.22);
        border-radius: 13px;

        color: var(--primary);
    }

    .form-header h2 {
        margin: 0;
        color: var(--text-main);
        font-size: 1.5rem;
        font-weight: 600;
    }

    .form-header p {
        margin: 5px 0 0;
        color: var(--text-muted);
        font-size: 0.86rem;
    }

    .form-card {
        width: 100%;
        box-sizing: border-box;

        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;

        padding: 32px 35px;

        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.14);
    }

    .form-group {
        width: 100%;
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 9px;

        color: var(--text-main);
        font-size: 0.84rem;
        font-weight: 600;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;

        background: #181c2a;
        border: 1px solid var(--border-color);
        border-radius: 9px;

        color: var(--text-main);
        font-family: inherit;
        font-size: 0.86rem;

        outline: none;
        transition: all 0.2s ease;
    }

    .form-input, .form-select {
        height: 45px;
    }

    .form-textarea {
        resize: vertical;
        min-height: 90px;
    }

    .form-input:hover,
    .form-select:hover,
    .form-textarea:hover {
        border-color: rgba(243, 156, 18, 0.35);
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.08);
    }

    .form-input::placeholder, .form-textarea::placeholder {
        color: #64748b;
    }

    .form-select {
        cursor: pointer;
    }

    .form-select option {
        background: #181c2a;
        color: var(--text-main);
    }

    .form-hint {
        display: block;
        margin-top: 7px;

        color: var(--text-muted);
        font-size: 0.74rem;
        line-height: 1.5;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        gap: 10px;

        margin-top: 32px;
        padding-top: 24px;

        border-top: 1px solid var(--border-color);
    }

    .btn-kembali,
    .btn-simpan {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 7px;

        min-width: 110px;
        height: 40px;

        box-sizing: border-box;
        padding: 0 16px;

        border-radius: 8px;

        font-family: inherit;
        font-size: 0.82rem;
        font-weight: 600;

        text-decoration: none;
        cursor: pointer;

        transition: all 0.2s ease;
    }

    .btn-kembali {
        background: rgba(148, 163, 184, 0.07);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    .btn-kembali:hover {
        background: rgba(148, 163, 184, 0.13);
        color: var(--text-main);
        transform: translateY(-1px);
    }

    .btn-simpan {
        background: var(--primary);
        color: #111827;
        border: 1px solid var(--primary);

        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.15);
    }

    .btn-simpan:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(243, 156, 18, 0.25);
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 24px 20px;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn-kembali,
        .btn-simpan {
            width: 100%;
        }
    }
</style>

<div class="form-container">

    <div class="form-header">
        <div class="form-icon">
            <i data-feather="user-plus"></i>
        </div>
        <div>
            <h2>Tambah Pelanggan</h2>
            <p>Tambahkan data pelanggan baru ke sistem rental</p>
        </div>
    </div>

    <?php
    if (isset($_POST['simpan'])) {
        $id_pelanggan   = mysqli_real_escape_string($koneksi, $_POST['id_pelanggan']);
        $nik            = mysqli_real_escape_string($koneksi, $_POST['nik']);
        $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
        $alamat         = mysqli_real_escape_string($koneksi, $_POST['alamat']);
        $no_telp        = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
        $id_kategori    = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);

        // Query disesuaikan dengan kolom di database: id_pelanggan, nik, nama_pelanggan, alamat, no_telp, id_kategori[cite: 11]
        $sql = "INSERT INTO pelanggan (id_pelanggan, nik, nama_pelanggan, alamat, no_telp, id_kategori) 
                VALUES ('$id_pelanggan', '$nik', '$nama_pelanggan', '$alamat', '$no_telp', '$id_kategori')";

        if ($koneksi->query($sql)) {
            echo "<script>
                    alert('Pelanggan berhasil ditambahkan!');
                    window.location='halaman_admin.php?open=data_pelanggan';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Gagal menambahkan pelanggan: " . addslashes($koneksi->error) . "');
                  </script>";
        }
    }
    ?>

    <div class="form-card">
        <form method="POST">

            <!-- ID PELANGGAN -->
            <div class="form-group">
                <label class="form-label">ID Pelanggan</label>
                <input type="text" name="id_pelanggan" class="form-input" placeholder="Contoh: PLG-004" required>
            </div>

            <!-- NIK -->
            <div class="form-group">
                <label class="form-label">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" class="form-input" placeholder="Masukkan 16 digit NIK" required>
            </div>

            <!-- NAMA PELANGGAN -->
            <div class="form-group">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-input" placeholder="Masukkan nama lengkap pelanggan" required>
            </div>

            <!-- ALAMAT (TAMBAHAN BARU) -->
            <div class="form-group">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" class="form-textarea" placeholder="Masukkan alamat domisili pelanggan" required></textarea>
            </div>

            <!-- NO TELEPON -->
            <div class="form-group">
                <label class="form-label">No. Telepon / WhatsApp</label>
                <input type="tel" name="no_telp" class="form-input" placeholder="Contoh: 081234567890" required>
            </div>

            <!-- KATEGORI PELANGGAN -->
            <div class="form-group">
                <label class="form-label">Kategori Pelanggan</label>
                <select name="id_kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori Pelanggan --</option>
                    <?php
                    $kategori = $koneksi->query("SELECT id_kategori, nama_kategori, diskon FROM kategori_pelanggan ORDER BY id_kategori ASC");
                    while ($row = $kategori->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id_kategori']) . "'>" 
                             . htmlspecialchars($row['nama_kategori']) . " - Diskon " . htmlspecialchars($row['diskon']) . "%</option>";
                    }
                    ?>
                </select>
                <span class="form-hint">Kategori dan diskon diambil otomatis dari data kategori pelanggan.</span>
            </div>

            <!-- BUTTON ACTIONS -->
            <div class="form-actions">
                <a href="halaman_admin.php?open=data_pelanggan" class="btn-kembali">
                    <i data-feather="arrow-left" style="width:15px;"></i> Kembali
                </a>
                <button type="submit" name="simpan" class="btn-simpan">
                    <i data-feather="save" style="width:15px;"></i> Simpan Pelanggan
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>