<?php
include_once "../src/koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    echo "<script>
            alert('ID kamera tidak ditemukan!');
            window.location='halaman_admin.php?open=data_kamera';
          </script>";
    exit;
}


/* =========================
   AMBIL DATA KAMERA
   ========================= */

$stmt = $koneksi->prepare(
    "SELECT * FROM kamera WHERE id_kamera = ?"
);

$stmt->bind_param("s", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>
            alert('Data kamera tidak ditemukan!');
            window.location='halaman_admin.php?open=data_kamera';
          </script>";
    exit;
}

$kamera = $result->fetch_assoc();


/* =========================
   PROSES UPDATE
   ========================= */

if (isset($_POST['update'])) {

    $nama_kamera = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_kamera']
    );

    $merk = mysqli_real_escape_string(
        $koneksi,
        $_POST['merk']
    );

    $tarif_per_hari = mysqli_real_escape_string(
        $koneksi,
        $_POST['tarif_per_hari']
    );

    $stok = mysqli_real_escape_string(
        $koneksi,
        $_POST['stok']
    );

    $gambar = mysqli_real_escape_string(
        $koneksi,
        $_POST['gambar']
    );


    $sql = "UPDATE kamera SET
                nama_kamera = '$nama_kamera',
                merk = '$merk',
                tarif_per_hari = '$tarif_per_hari',
                stok = '$stok',
                gambar = '$gambar'
            WHERE id_kamera = '$id'";


    if ($koneksi->query($sql)) {

        echo "<script>
                alert('Data kamera berhasil diperbarui!');
                window.location='halaman_admin.php?open=data_kamera';
              </script>";

        exit;

    } else {

        echo "<script>
                alert('Gagal memperbarui data kamera: " .
                addslashes($koneksi->error) .
                "');
              </script>";
    }
}
?>


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

    .form-input {
        width: 100%;
        height: 45px;

        box-sizing: border-box;
        padding: 0 14px;

        background: #181c2a;
        border: 1px solid var(--border-color);
        border-radius: 9px;

        color: var(--text-main);
        font-family: inherit;
        font-size: 0.86rem;

        outline: none;
        transition: all 0.2s ease;
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
        margin-top: 7px;

        color: var(--text-muted);
        font-size: 0.74rem;
        line-height: 1.5;
    }

    .preview-gambar {
        width: 140px;
        height: 95px;
        object-fit: cover;

        margin-top: 10px;

        border-radius: 10px;
        border: 1px solid var(--border-color);
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
            <i data-feather="edit-2"></i>
        </div>

        <div>

            <h2>Edit Kamera</h2>

            <p>
                Perbarui data kamera rental
            </p>

        </div>

    </div>


    <div class="form-card">

        <form method="POST">

            <!-- ID KAMERA -->

            <div class="form-group">

                <label class="form-label">
                    ID Kamera
                </label>

                <input
                    type="text"
                    class="form-input"
                    value="<?= htmlspecialchars($kamera['id_kamera']); ?>"
                    readonly
                >

                <span class="form-hint">
                    ID kamera tidak dapat diubah.
                </span>

            </div>


            <!-- NAMA KAMERA -->

            <div class="form-group">

                <label class="form-label">
                    Nama Kamera
                </label>

                <input
                    type="text"
                    name="nama_kamera"
                    class="form-input"
                    value="<?= htmlspecialchars($kamera['nama_kamera']); ?>"
                    placeholder="Masukkan nama kamera"
                    required
                >

            </div>


            <!-- MERK -->

            <div class="form-group">

                <label class="form-label">
                    Merk
                </label>

                <input
                    type="text"
                    name="merk"
                    class="form-input"
                    value="<?= htmlspecialchars($kamera['merk']); ?>"
                    placeholder="Contoh: Canon"
                    required
                >

            </div>


            <!-- TARIF -->

            <div class="form-group">

                <label class="form-label">
                    Tarif Per Hari
                </label>

                <input
                    type="number"
                    name="tarif_per_hari"
                    class="form-input"
                    value="<?= htmlspecialchars($kamera['tarif_per_hari']); ?>"
                    placeholder="Contoh: 150000"
                    min="0"
                    required
                >

                <span class="form-hint">
                    Masukkan tarif rental dalam Rupiah.
                </span>

            </div>


            <!-- STOK -->

            <div class="form-group">

                <label class="form-label">
                    Stok
                </label>

                <input
                    type="number"
                    name="stok"
                    class="form-input"
                    value="<?= htmlspecialchars($kamera['stok']); ?>"
                    placeholder="Contoh: 5"
                    min="0"
                    required
                >

            </div>


            <!-- GAMBAR -->

            <div class="form-group">

                <label class="form-label">
                    URL / Path Gambar
                </label>

                <input
                    type="text"
                    name="gambar"
                    class="form-input"
                    value="<?= htmlspecialchars($kamera['gambar']); ?>"
                    placeholder="Contoh: gambar/canon.jpg"
                >

                <span class="form-hint">
                    Masukkan URL atau lokasi file gambar kamera.
                </span>


                <?php if (!empty($kamera['gambar'])) { ?>

                    <img
                        src="<?= htmlspecialchars($kamera['gambar']); ?>"
                        alt="Preview Kamera"
                        class="preview-gambar"
                    >

                <?php } ?>

            </div>


            <!-- BUTTON -->

            <div class="form-actions">

                <a
                    href="halaman_admin.php?open=data_kamera"
                    class="btn-kembali"
                >

                    <i
                        data-feather="arrow-left"
                        style="width:15px;"
                    ></i>

                    Kembali

                </a>


                <button
                    type="submit"
                    name="update"
                    class="btn-simpan"
                >

                    <i
                        data-feather="save"
                        style="width:15px;"
                    ></i>

                    Simpan Perubahan

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

