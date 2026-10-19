<?php 
include_once "../src/koneksi.php"; 

// Tangkap filter bulan dan tahun (Default: Bulan dan tahun saat ini)
$bulan_pilih = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun_pilih = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Array nama bulan dalam Bahasa Indonesia
$nama_bulan = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
    <div>
        <h2><b>Rekap Transaksi Bulanan</b></h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Laporan rekapitulasi penyewaan kamera berdasarkan bulan.</p>
    </div>

    <!-- Filter Bulan & Tahun -->
    <form method="GET" action="halaman_admin.php" style="display: flex; gap: 10px; align-items: center;">
        <input type="hidden" name="open" value="rekap_transaksi">
        
        <select name="bulan" class="form-select" style="height: 40px; padding: 0 12px; background: #181c2a; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); font-family: inherit;">
            <?php foreach ($nama_bulan as $key => $nama): ?>
                <option value="<?= $key; ?>" <?= ($bulan_pilih == $key) ? 'selected' : ''; ?>><?= $nama; ?></option>
            <?php endforeach; ?>
        </select>

        <select name="tahun" class="form-select" style="height: 40px; padding: 0 12px; background: #181c2a; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-main); font-family: inherit;">
            <?php 
            $tahun_mulai = 2025; 
            $tahun_maksimal = date('Y') + 1; 
            for ($t = $tahun_maksimal; $t >= $tahun_mulai; $t--): 
            ?>
                <option value="<?= $t; ?>" <?= ($tahun_pilih == $t) ? 'selected' : ''; ?>><?= $t; ?></option>
            <?php endfor; ?>
        </select>

        <button type="submit" style="background: var(--primary); color: #111827; border: none; padding: 0 15px; height: 40px; border-radius: 8px; font-weight: 600; cursor: pointer;">
            Filter
        </button>
    </form>
</div>

<?php
// Ambil statistik ringkasan rekap untuk bulan & tahun yang dipilih
$stat_query = $koneksi->query("SELECT 
    COUNT(id_transaksi) as total_trx,
    SUM(total_harga) as total_pendapatan,
    SUM(denda) as total_denda
    FROM transaksi 
    WHERE MONTH(tgl_sewa) = '$bulan_pilih' AND YEAR(tgl_sewa) = '$tahun_pilih'");
$stat = $stat_query->fetch_assoc();
?>

<!-- KOTAK RINGKASAN STATISTIK -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 25px;">
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px;">
        <span style="color: var(--text-muted); font-size: 0.82rem; text-transform: uppercase; font-weight: 600;">Total Transaksi</span>
        <h3 style="color: #fff; font-size: 1.6rem; margin-top: 5px; border:none; padding:0;"><?= number_format($stat['total_trx'] ?? 0, 0, ',', '.'); ?> Sewa</h3>
    </div>
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px;">
        <span style="color: var(--text-muted); font-size: 0.82rem; text-transform: uppercase; font-weight: 600;">Total Pendapatan Sewa</span>
        <h3 style="color: #10b981; font-size: 1.6rem; margin-top: 5px; border:none; padding:0;">Rp <?= number_format($stat['total_pendapatan'] ?? 0, 0, ',', '.'); ?></h3>
    </div>
    <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; padding: 20px;">
        <span style="color: var(--text-muted); font-size: 0.82rem; text-transform: uppercase; font-weight: 600;">Total Denda Terkumpul</span>
        <h3 style="color: #ef4444; font-size: 1.6rem; margin-top: 5px; border:none; padding:0;">Rp <?= number_format($stat['total_denda'] ?? 0, 0, ',', '.'); ?></h3>
    </div>
</div>

<!-- TABEL RINCIAN TRANSAKSI BULAN INI -->
<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
    <div style="padding: 18px 20px; border-bottom: 1px solid var(--border-color); background: #181c2a; font-weight: 600; font-size: 0.9rem;">
        Rincian Transaksi Bulan <?= $nama_bulan[$bulan_pilih]; ?> <?= $tahun_pilih; ?>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; white-space: nowrap;">
            <thead>
                <tr style="background: #181c2a;">
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">No</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">ID TRX</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Pelanggan</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Kamera</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Petugas</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Tgl Sewa</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Tgl Kembali</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Total Harga</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Denda</th>
                    <th style="padding: 14px 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT t.*, p.nama_pelanggan, k.nama_kamera, k.merk, pt.nama_petugas 
                          FROM transaksi t
                          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                          JOIN kamera k ON t.id_kamera = k.id_kamera
                          LEFT JOIN petugas pt ON t.id_petugas = pt.id_petugas
                          WHERE MONTH(t.tgl_sewa) = '$bulan_pilih' AND YEAR(t.tgl_sewa) = '$tahun_pilih'
                          ORDER BY t.id_transaksi DESC";
                          
                $sql = mysqli_query($koneksi, $query);
                $nomor = 0;

                if ($sql && mysqli_num_rows($sql) > 0) {
                    while ($data = mysqli_fetch_assoc($sql)) {
                        $nomor++;
                ?>
                <tr style="transition: 0.2s;" onmouseover="this.style.background='rgba(243,156,18,0.03)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);"><?php echo $nomor; ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color);"><b style="color: var(--primary);">TRX-<?php echo str_pad($data['id_transaksi'], 3, '0', STR_PAD_LEFT); ?></b></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); font-weight: 500;"><?php echo htmlspecialchars($data['nama_pelanggan']); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color);"><?php echo htmlspecialchars($data['merk'] . " " . $data['nama_kamera']); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);"><?php echo htmlspecialchars($data['nama_petugas'] ?? '-'); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);"><?php echo date('d M Y', strtotime($data['tgl_sewa'])); ?></td>
                    
                    <!-- Kolom Tgl Kembali & Tanggal Dikembalikan -->
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);">
                        <?php echo date('d M Y', strtotime($data['tgl_kembali'])); ?>
                        <?php if (!empty($data['tgl_dikembalikan'])): ?>
                            <br><small style="color: #10b981;">Dikembalikan: <?php echo date('d M Y', strtotime($data['tgl_dikembalikan'])); ?></small>
                        <?php else: ?>
                            <br><small style="color: #f59e0b;">Belum dikembalikan</small>
                        <?php endif; ?>
                    </td>

                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); font-weight: 600; color: #10b981;">Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); font-weight: 600; color: <?php echo ($data['denda'] > 0) ? '#ef4444' : 'var(--text-muted);'; ?>">Rp <?php echo number_format($data['denda'], 0, ',', '.'); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color);">
                        <?php 
                        if ($data['status_sewa'] == 'Berjalan') {
                            echo "<span style='background: rgba(245,158,11,0.15); color: #f59e0b; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;'>Berjalan</span>";
                        } elseif ($data['status_sewa'] == 'Selesai') {
                            echo "<span style='background: rgba(16,185,129,0.15); color: #10b981; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;'>Selesai</span>";
                        } else {
                            echo "<span style='background: rgba(239,68,68,0.15); color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;'>".$data['status_sewa']."</span>";
                        }
                        ?>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='10' style='text-align: center; padding: 30px; color: var(--text-muted);'>Tidak ada data transaksi pada bulan ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>