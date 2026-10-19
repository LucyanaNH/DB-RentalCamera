<?php
include_once "../src/koneksi.php";

$pesan_error = "";

// Proses simpan transaksi
if (isset($_POST['simpan'])) {$id_pelanggan = mysqli_real_escape_string($koneksi,$_POST['id_pelanggan']);
    $id_kamera = mysqli_real_escape_string($koneksi, $_POST['id_kamera']);$id_petugas = mysqli_real_escape_string($koneksi,$_POST['id_petugas']); // Ambil id_petugas dari form
    $tgl_sewa = mysqli_real_escape_string($koneksi, $_POST['tgl_sewa']);$tgl_kembali = mysqli_real_escape_string($koneksi,$_POST['tgl_kembali']);
    $total_harga = floatval($_POST['total_harga_hidden']);

    // Validasi tanggal
    if (strtotime($tgl_kembali) < strtotime($tgl_sewa)) {$pesan_error = "Tanggal kembali tidak boleh lebih awal dari tanggal sewa!";
    } else {
        // Gunakan Transaction untuk keamanan data
        $koneksi->begin_transaction();

        try {
            // 1. Insert ke tabel transaksi (beserta id_petugas)
            $sql_insert = "INSERT INTO transaksi (id_pelanggan, id_kamera, id_petugas, tgl_sewa, tgl_kembali, total_harga, status_sewa, status_pembayaran) 
                           VALUES ('$id_pelanggan', '$id_kamera', '$id_petugas', '$tgl_sewa', '$tgl_kembali',$total_harga, 'Berjalan', 'Belum Lunas')";
            
            if (!$koneksi->query($sql_insert)) {
                throw new Exception("Gagal menyimpan data transaksi: " . $koneksi->error);
            }

            // 2. Kurangi stok kamera
            $sql_stok = "UPDATE kamera SET stok = stok - 1 WHERE id_kamera = '$id_kamera' AND stok > 0";
            if (!$koneksi->query($sql_stok)||$koneksi->affected_rows == 0) {
                throw new Exception("Stok kamera habis atau kamera tidak ditemukan!");
            }

            // Commit transaksi jika sukses
            $koneksi->commit();

            echo "<script>
                    alert('Transaksi sewa berhasil ditambahkan!');
                    window.location='halaman_admin.php?open=data_transaksi';
                  </script>";
            exit();

        } catch (Exception $e) {$koneksi->rollback();
            $pesan_error =$e->getMessage();
        }
    }
}
?>

<style>
    .form-container { width: 100%; max-width: 850px; margin: 0 auto; }
    .form-header { display: flex; align-items: center; gap: 15px; margin-bottom: 28px; }
    .form-icon { width: 50px; height: 50px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: rgba(243, 156, 18, 0.10); border: 1px solid rgba(243, 156, 18, 0.22); border-radius: 13px; color: var(--primary); }
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
    
    /* Kotak Informasi Diskon */
    .badge-diskon-box {
        display: none;
        margin-top: 8px;
        padding: 10px 14px;
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.25);
        border-radius: 8px;
        color: #4ade80;
        font-size: 0.82rem;
        font-weight: 500;
        align-items: center;
        gap: 8px;
    }
</style>

<div class="form-container">

    <div class="form-header">
        <div class="form-icon">
            <i data-feather="shopping-cart"></i>
        </div>
        <div>
            <h2>Buat Transaksi Sewa</h2>
            <p>Catat penyewaan kamera baru dengan potongan diskon otomatis</p>
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
                    <option value="" data-diskon="0" data-kategori="-">-- Pilih Pelanggan --</option>
                    <?php
                    $cust_query =$koneksi->query("SELECT p.id_pelanggan, p.nama_pelanggan, k.nama_kategori, k.diskon 
                                                   FROM pelanggan p 
                                                   JOIN kategori_pelanggan k ON p.id_kategori = k.id_kategori 
                                                   ORDER BY p.nama_pelanggan ASC");
                    while ($cust =$cust_query->fetch_assoc()) {
                        echo "<option value='".$cust['id_pelanggan']."' data-diskon='".$cust['diskon']."' data-kategori='".$cust['nama_kategori']."'>"
                             .$cust['nama_pelanggan']." (".$cust['nama_kategori'].")"
                             ."</option>";
                    }
                    ?>
                </select>
                
                <!-- Kotak Informasi Diskon Pelanggan -->
                <div id="infoDiskonBox" class="badge-diskon-box">
                    <i data-feather="tag" style="width: 15px; height: 15px;"></i>
                    <span id="teksDiskon">Pelanggan ini mendapatkan diskon 0%</span>
                </div>
            </div>

            <!-- PILIH KAMERA -->
            <div class="form-group">
                <label class="form-label">Kamera</label>
                <select name="id_kamera" id="id_kamera" class="form-select" required onchange="hitungTotal()">
                    <option value="" data-tarif="0">-- Pilih Kamera --</option>
                    <?php
                    $cam_query =$koneksi->query("SELECT id_kamera, nama_kamera, merk, tarif_per_hari, stok FROM kamera WHERE stok > 0");
                    while ($cam =$cam_query->fetch_assoc()) {
                        echo "<option value='".$cam['id_kamera']."' data-tarif='".$cam['tarif_per_hari']."'>"
                             .$cam['merk']." ".$cam['nama_kamera']." - Rp ".number_format($cam['tarif_per_hari'], 0, ',', '.')."/hari (Stok: ".$cam['stok'].")
                             </option>";
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
                    $petugas_query =$koneksi->query("SELECT id_petugas, nama_petugas FROM petugas ORDER BY nama_petugas ASC");
                    while ($p =$petugas_query->fetch_assoc()) {
                        // Jika ada session id_petugas yang login, kita bisa set otomatis selected
                        $selected = (isset($_SESSION['id_petugas']) && $_SESSION['id_petugas'] ==$p['id_petugas']) ? 'selected' : '';
                        echo "<option value='".$p['id_petugas']."' $selected>".$p['nama_petugas']." (ID: ".$p['id_petugas'].")</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- TANGGAL SEWA & KEMBALI -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Sewa</label>
                    <input type="date" name="tgl_sewa" id="tgl_sewa" class="form-input" required value="<?= date('Y-m-d'); ?>" onchange="hitungTotal()">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Kembali (Batas Pengembalian)</label>
                    <input type="date" name="tgl_kembali" id="tgl_kembali" class="form-input" required value="<?= date('Y-m-d', strtotime('+1 day')); ?>" onchange="hitungTotal()">
                </div>
            </div>

            <!-- TOTAL HARGA & DISKON -->
            <div class="form-group">
                <label class="form-label">Total Harga Setelah Diskon</label>
                <div class="total-box">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <input type="text" id="total_harga_tampil" readonly style="background: transparent; border: none; color: #10b981; font-size: 1.3rem; font-weight: bold; width: 100%; outline: none;" value="Rp 0">
                        <span id="detailSubtotal" style="color: var(--text-muted); font-size: 0.78rem;"></span>
                    </div>
                    <input type="hidden" name="total_harga_hidden" id="total_harga_hidden" value="0">
                </div>
            </div>

            <!-- BUTTONS -->
            <div class="form-actions">
                <a href="halaman_admin.php?open=data_transaksi" class="btn-kembali">
                    <i data-feather="arrow-left" style="width:15px;"></i> Kembali
                </a>
                <button type="submit" name="simpan" class="btn-simpan">
                    <i data-feather="save" style="width:15px;"></i> Proses Sewa
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
        
        const selectedOptionPelanggan = pelangganSelect.options[pelangganSelect.selectedIndex];
        const diskonPersen = parseFloat(selectedOptionPelanggan.getAttribute('data-diskon')) || 0;
        const namaKategori = selectedOptionPelanggan.getAttribute('data-kategori') || '-';

        // Tampilkan kotak info diskon jika pelanggan dipilih
        const infoBox = document.getElementById('infoDiskonBox');
        const teksDiskon = document.getElementById('teksDiskon');
        
        if (pelangganSelect.value !== "") {
            infoBox.style.display = "flex";
            if (diskonPersen > 0) {
                teksDiskon.innerHTML = `Pelanggan kategori <b>${namaKategori}</b> mendapatkan diskon sebesar <b style="color: #4ade80;">${diskonPersen}%</b>`;
            } else {
                teksDiskon.innerHTML = `Pelanggan kategori <b>${namaKategori}</b> tidak mendapatkan diskon (0%)`;
            }
        } else {
            infoBox.style.display = "none";
        }

        if (tglSewa && tglKembali && tglKembali >= tglSewa) {
            const selisihWaktu = tglKembali.getTime() - tglSewa.getTime();
            const selisihHari = Math.ceil(selisihWaktu / (1000 * 3600 * 24));
            const hariSewa = selisihHari === 0 ? 1 : selisihHari; 

            // Hitung subtotal dan potongan diskon
            const subtotal = hariSewa * tarifPerHari;
            const potongan = (subtotal * diskonPersen) / 100;
            const totalHarga = subtotal - potongan;

            document.getElementById('total_harga_tampil').value = 'Rp ' + totalHarga.toLocaleString('id-ID');
            
            if (diskonPersen > 0) {
                document.getElementById('detailSubtotal').innerText = `Subtotal: Rp ${subtotal.toLocaleString('id-ID')} (Diskon ${diskonPersen}%)`;
            } else {
                document.getElementById('detailSubtotal').innerText = `${hariSewa} hari sewa`;
            }

            document.getElementById('total_harga_hidden').value = totalHarga;
        } else {
            document.getElementById('total_harga_tampil').value = 'Rp 0';
            document.getElementById('detailSubtotal').innerText = '';
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

    window.onload = function() {
        hitungTotal();
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    };
</script>