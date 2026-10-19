<?php include_once "../src/koneksi.php"; ?>

<style>
    .form-container {
        width: 100%;
    }

    .form-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 25px;
    }

    .form-icon {
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

    .form-header h2 {
        margin: 0;
        color: var(--text-main);
        font-size: 1.45rem;
        font-weight: 600;
    }

    .form-header p {
        margin: 4px 0 0;
        color: var(--text-muted);
        font-size: 0.85rem;
    }

    .form-card {
        max-width: 750px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        padding: 28px;
        box-sizing: border-box;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 7px;
        color: var(--text-main);
        font-size: 0.84rem;
        font-weight: 600;
    }

    .form-input {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        background: #181c2a;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-main);
        font-size: 0.86rem;
        outline: none;
        transition: 0.2s ease;
    }

    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.08);
    }

    .form-input::placeholder {
        color: #64748b;
    }

    .form-hint {
        display: block;
        margin-top: 6px;
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .btn-kembali,
    .btn-simpan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 0.84rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-kembali {
        background: rgba(148, 163, 184, 0.08);
        color: var(--text-muted);
        border: 1px solid var(--border-color);
    }

    .btn-kembali:hover {
        background: rgba(148, 163, 184, 0.14);
        color: var(--text-main);
    }

    .btn-simpan {
        background: var(--primary);
        color: #111827;
        border: 1px solid var(--primary);
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.15);
    }

    .btn-simpan:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(243, 156, 18, 0.25);
    }

    @media (max-width: 600px) {
        .form-card {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-actions {
            flex-direction: column-reverse;
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
        <i data-feather="camera"></i>
    </div>

    <div>
        <h2>Tambah Kamera</h2>
        <p>Tambahkan kamera baru ke inventaris rental</p>
    </div>

</div>


<?php
if (isset($_POST['simpan'])) {

    $id_kamera      = mysqli_real_escape_string($koneksi, $_POST['id_kamera']);
    $nama_kamera    = mysqli_real_escape_string($koneksi, $_POST['nama_kamera']);
    $merk           = mysqli_real_escape_string($koneksi, $_POST['merk']);
    $tarif_per_hari = mysqli_real_escape_string($koneksi, $_POST['tarif_per_hari']);
    $stok           = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $gambar         = mysqli_real_escape_string($koneksi, $_POST['gambar']);

    $sql = "INSERT INTO kamera
            (id_kamera, nama_kamera, merk, tarif_per_hari, stok, gambar)
            VALUES
            ('$id_kamera', '$nama_kamera', '$merk', '$tarif_per_hari', '$stok', '$gambar')";

    if ($koneksi->query($sql)) {

        echo "<script>
                alert('Kamera berhasil ditambahkan!');
                window.location='halaman_admin.php?open=data_kamera';
              </script>";

        exit;

    } else {

        echo "<script>
                alert('Gagal menambahkan kamera: " . addslashes($koneksi->error) . "');
              </script>";
    }
}
?>


<div class="form-card">

    <form method="POST">

        <div class="form-group">

            <label class="form-label">
                ID Kamera
            </label>

            <input
                type="text"
                name="id_kamera"
                class="form-input"
                placeholder="Contoh: KMR001"
                required
            >

        </div>


        <div class="form-group">

            <label class="form-label">
                Nama Kamera
            </label>

            <input
                type="text"
                name="nama_kamera"
                class="form-input"
                placeholder="Contoh: EOS 90D"
                required
            >

        </div>


        <div class="form-row">

            <div class="form-group">

                <label class="form-label">
                    Merk Kamera
                </label>

                <input
                    type="text"
                    name="merk"
                    class="form-input"
                    placeholder="Contoh: Canon"
                    required
                >

            </div>


            <div class="form-group">

                <label class="form-label">
                    Stok
                </label>

                <input
                    type="number"
                    name="stok"
                    class="form-input"
                    placeholder="Contoh: 5"
                    min="0"
                    required
                >

            </div>

        </div>


        <div class="form-group">

            <label class="form-label">
                Tarif Per Hari
            </label>

            <input
                type="number"
                name="tarif_per_hari"
                class="form-input"
                placeholder="Contoh: 150000"
                min="0"
                required
            >

            <span class="form-hint">
                Masukkan tarif dalam Rupiah tanpa tanda titik.
            </span>

        </div>


        <div class="form-group">

            <label class="form-label">
                Gambar Kamera
            </label>

            <input
                type="text"
                name="gambar"
                class="form-input"
                placeholder="Contoh: images/camera.jpg"
            >

            <span class="form-hint">
                Masukkan lokasi file gambar atau URL gambar kamera.
            </span>

        </div>


        <div class="form-actions">

            <a
                href="halaman_admin.php?open=data_kamera"
                class="btn-kembali"
            >
                <i data-feather="arrow-left" style="width:15px;"></i>
                Kembali
            </a>


            <button
                type="submit"
                name="simpan"
                class="btn-simpan"
            >
                <i data-feather="save" style="width:15px;"></i>
                Simpan Kamera
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
