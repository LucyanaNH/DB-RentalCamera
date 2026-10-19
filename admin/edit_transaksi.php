<?php 
include_once "../src/koneksi.php"; 

$id_transaksi = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data transaksi berdasarkan ID
$query_trx = $koneksi->query("SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi");
$data = $query_trx->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data transaksi tidak ditemukan!'); window.location='halaman_admin.php?open=data_transaksi';</script>";
    exit();
}

$pesan_error = "";

// Proses Update Transaksi
if (isset($_POST['update'])) {
    $id_pelanggan = mysqli_real_escape_string($koneksi, $_POST['id_pelanggan']);
    $id_kamera = mysqli_real_escape_string($koneksi, $_POST['id_kamera']);
    $id_petugas = mysqli_real_escape_string($koneksi, $_POST['id_petugas']); // Ambil pilihan petugas dari form edit
    $tgl_sewa = mysqli_real_escape_string($koneksi, $_POST['tgl_sewa']);
    $tgl_kembali = mysqli_real_escape_string($koneksi, $_POST['tgl_kembali']);
    $total_harga = floatval($_POST['total_harga_hidden']);
    $status_sewa = mysqli_real_escape_string($koneksi, $_POST['status_sewa']);
    $status_pembayaran = mysqli_real_escape_string($koneksi, $_POST['status_pembayaran']);

    if (strtotime($tgl_kembali) < strtotime($tgl_sewa)) {
        $pesan_error = "Tanggal kembali tidak boleh lebih awal dari tanggal sewa!";
    } else {
        $sql_update = "UPDATE transaksi SET 
                        id_pelanggan = '$id_pelanggan', 
                        id_kamera = '$id_kamera', 
                        id_petugas = '$id_petugas',
                        tgl_sewa = '$tgl_sewa', 
                        tgl_kembali = '$tgl_kembali', 
                        total_harga = $total_harga, 
                        status_sewa = '$status_sewa', 
                        status_pembayaran = '$status_pembayaran' 
                       WHERE id_transaksi = $id_transaksi";

        if ($koneksi->query($sql_update)) {
            echo "<script>
                    alert('Data transaksi berhasil diperbarui!');
                    window.location='halaman_admin.php?open=data_transaksi';
                  </script>";
            exit();
        } else {
            $pesan_error = "Gagal memperbarui transaksi: " . $koneksi->error;
        }
    }
}
?>

<style>
    .form-container { width: 100%; max-width: 850px; margin: 0 auto; }
    .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 28px; }
    .form-icon { width: 50px; height: 50px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(59, 130, 246, 0.10); border: 1px solid rgba(59, 130, 246, 0.22); border-radius: 13px; color: #60a5fa; }
    .form-header h2 { margin: 0; color: var(--text-main); font-size: 1.5rem; font-weight: 600; }
    .form-header p { margin: 5px 0 0; color: var(--text-muted); font-size: 0.86rem; }
    .form-card { width: 100%; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 16px; padding: 32px 35px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.14); }
    .form-group { width: 100%; margin-bottom: 24px; }
    .form-label { display: block; margin-bottom: 9px; color: var(--text-main); font-size: 0.84rem; font-weight: 600; }
    .form-input, .form-select { width: 100%; height: 45px; box-sizing: border-box; padding: 0 14px; background: #181c2a; border: 1px solid var(--border-color); border-radius: 9px; color: var(--text-main); font-family: inherit; font-size: 0.86rem; outline: none; transition: all 0.2s ease; }
    .form-input:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.08); }
    .form-select option { background: #181c2a; color: var(--text-main); }
    .total-box { background: #181c2a; border: 1px solid var(--border-color); border-radius: 9px; padding: 15px; margin-top: 5px; }
    .form-actions { display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-top: 32px; padding-top: 24px; border-top: 1px solid var(--border-color); }
    .btn-kembali, .btn-simpan { display: inline-flex; align-items: center; justify-content: center; gap: 7px; min-width: 110px; height: 40px; padding: 0 16px; border-radius: 8px; font-family: inherit; font-size: 0.82rem; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s ease; }
    .btn-kembali { background: rgba(148, 163, 184, 0.07); color: var(--text-muted); border: 1px solid var(--border-color); }
    .btn-simpan { background: var(--primary); color: #111827; border: 1px solid var(--primary); box-shadow: 0 4px 12px rgba(243, 156, 18, 0.15); }
    .diskon-info { color: #4ade80; font-size: 0.78rem; margin-top: 5px; display: block; font-weight: 500; }
</style>

<div class="form-container">

    <div class="form-header">
        <div class="form-icon">
            <i data-feather="edit-2"></i>
        </div>
        <div>
            <h2>Edit Transaksi Sewa</h2>
            <p>Perbarui data penyewaan kamera #TRX-<?= str_pad($data['id_transaksi'], 3, '0', STR_PAD_LEFT); ?></p>
        </div>
    </div>

    <?php if ($pesan_error != ""): ?>
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; padding: 12px 16px; border-radius: 9px; margin-bottom: 20px; font-size: 0.85rem;">
            <?= $pesan_error; ?>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form method="POST" onsubmit="return validateForm()">

            <!-- PILIH PELANGGAN -->
            <div class="form-group">
                <label class="form-label">Pelanggan</label>
                <select name="id_pelanggan" id="id_pelanggan" class="form-select" required onchange="hitungTotal()">
                    <option value="" data-diskon="0">-- Pilih Pelanggan --</option>
                    <?php
                    $cust_query = $koneksi->query("SELECT p.id_pelanggan, p.nama_pelanggan, k.nama_kategori, k.diskon 
                                                   FROM pelanggan p 
                                                   JOIN kategori_pelanggan k ON p.id_kategori = k.id_kategori 
                                                   ORDER BY p.nama_pelanggan ASC");
                    while ($cust = $cust_query->fetch_assoc()) {
                        $selected = ($cust['id_pelanggan'] == $data['id_pelanggan']) ? 'selected' : '';
                        echo "<option value='".$cust['id_pelanggan']."' data-diskon='".$cust['diskon']."' $selected>"
                             .$cust['nama_pelanggan']." — [".$cust['nama_kategori']." : Diskon ".$cust['diskon']."%]"
                             ."</option>";
                    }
                    ?>
                </select>
                <span id="info_diskon" class="diskon-info"></span>
            </div>

            <!-- PILIH KAMERA -->
            <div class="form-group">
                <label class="form-label">Kamera</label>
                <select name="id_kamera" id="id_kamera" class="form-select" required onchange="hitungTotal()">
                    <option value="" data-tarif="0">-- Pilih Kamera --</option>
                    <?php
                    $cam_query = $koneksi->query("SELECT id_kamera, nama_kamera, merk, tarif_per_hari FROM kamera");
                    while ($cam = $cam_query->fetch_assoc()) {
                        $selected = ($cam['id_kamera'] == $data['id_kamera']) ? 'selected' : '';
                        echo "<option value='".$cam['id_kamera']."' data-tarif='".$cam['tarif_per_hari']."' $selected>"
                             .$cam['merk']." ".$cam['nama_kamera']." - Rp ".number_format($cam['tarif_per_hari'], 0, ',', '.')."/hari"
                             ."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- PILIH PETUGAS -->
            <div class="form-group">
                <label class="form-label">Petugas / Admin yang Melayani</label>
                <select name="id_petugas" class="form-select" required>
                    <option value="">-- Pilih Petugas --</option>
                    <?php
                    $petugas_query = $koneksi->query("SELECT id_petugas, nama_petugas FROM petugas ORDER BY nama_petugas ASC");
                    while ($p = $petugas_query->fetch_assoc()) {
                        $selected_petugas = ($p['id_petugas'] == $data['id_petugas']) ? 'selected' : '';
                        echo "<option value='".$p['id_petugas']."' $selected_petugas>".$p['nama_petugas']." (ID: ".$p['id_petugas'].")</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- TANGGAL SEWA & KEMBALI -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Sewa</label>
                    <input type="date" name="tgl_sewa" id="tgl_sewa" class="form-input" required value="<?= $data['tgl_sewa']; ?>" onchange="hitungTotal()">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Kembali</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-input" required value="<?= $data['tgl_kembali']; ?>" onchange="hitungTotal()">
                </div>
            </div>

            <!-- STATUS SEWA & PEMBAYARAN -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label class="form-label">Status Sewa</label>
                    <select name="status_sewa" class="form-select" required>
                        <option value="Berjalan" <?= ($data['status_sewa'] == 'Berjalan') ? 'selected' : ''; ?>>Berjalan</option>
                        <option value="Selesai" <?= ($data['status_sewa'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                        <option value="Terlambat" <?= ($data['status_sewa'] == 'Terlambat') ? 'selected' : ''; ?>>Terlambat</option>
                        <option value="Dibatalkan" <?= ($data['status_sewa'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="status_pembayaran" class="form-select" required>
                        <option value="Belum Lunas" <?= ($data['status_pembayaran'] == 'Belum Lunas') ? 'selected' : ''; ?>>Belum Lunas</option>
                        <option value="Lunas" <?= ($data['status_pembayaran'] == 'Lunas') ? 'selected' : ''; ?>>Lunas</option>
                    </select>
                </div>
            </div>

            <!-- TOTAL HARGA -->
            <div class="form-group">
                <label class="form-label">Total Harga Setelah Diskon</label>
                <div class="total-box">
                    <input type="text" id="total_harga_tampil" readonly style="background: transparent; border: none; color: #10b981; font-size: 1.3rem; font-weight: bold; width: 100%; outline: none;" value="Rp <?= number_format($data['total_harga'], 0, ',', '.'); ?>">
                    <input type="hidden" name="total_harga_hidden" id="total_harga_hidden" value="<?= $data['total_harga']; ?>">
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="form-actions">
                <a href="halaman_admin.php?open=data_transaksi" class="btn-kembali">
                    <i data-feather="arrow-left" style="width:15px;"></i> Kembali
                </a>
                <button type="submit" name="update" class="btn-simpan">
                    <i data-feather="save" style="width:15px;"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>

<script>
    function hitungTotal() {
        const pelangganSelect = document.getElementById('id_pelanggan');
        const kameraSelect = document.getElementById('id_kamera');
        const tglSewa = new Date(document.getElementById('tgl_sewa').value);
        const tglKembali = new Date(document.getElementById('tgl_kembali').value);
        
        const tarifPerHari = parseFloat(kameraSelect.options[kameraSelect.selectedIndex].getAttribute('data-tarif')) || 0;
        const diskonPersen = parseFloat(pelangganSelect.options[pelangganSelect.selectedIndex].getAttribute('data-diskon')) || 0;

        const infoDiskon = document.getElementById('info_diskon');
        if (diskonPersen > 0) {
            infoDiskon.innerText = "✓ Pelanggan ini mendapatkan potongan diskon sebesar " + diskonPersen + "%";
        } else {
            infoDiskon.innerText = "";
        }

        if (tglSewa && tglKembali && tglKembali >= tglSewa) {
            const selisihWaktu = tglKembali.getTime() - tglSewa.getTime();
            const selisihHari = Math.ceil(selisihWaktu / (1000 * 3600 * 24));
            const hariSewa = selisihHari === 0 ? 1 : selisihHari; 

            const subtotal = hariSewa * tarifPerHari;
            const jumlahDiskon = (subtotal * diskonPersen) / 100;
            const totalHarga = subtotal - jumlahDiskon;

            document.getElementById('total_harga_tampil').value = 'Rp ' + totalHarga.toLocaleString('id-ID') + (diskonPersen > 0 ? ' (Diskon ' + diskonPersen + '%)' : '');
            document.getElementById('total_harga_hidden').value = totalHarga;
        } else {
            document.getElementById('total_harga_tampil').value = 'Rp 0';
            document.getElementById('total_harga_hidden').value = 0;
        }
    }

    function validateForm() {
        const total = parseFloat(document.getElementById('total_harga_hidden').value);
        if (total <= 0) {
            alert('Durasi sewa atau total harga tidak valid!');
            return false;
        }
        return true;
    }

    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>