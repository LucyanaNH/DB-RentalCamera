<?php 
include_once "../src/koneksi.php"; 

// Proses pengembalian kamera (Jika tombol Selesai diklik)
if (isset($_GET['action']) && $_GET['action'] == 'kembali' && isset($_GET['id'])) {
    $trx_id = intval($_GET['id']);
    $tgl_dikembalikan = date('Y-m-d');
    
    $stmt_trx = $koneksi->prepare("SELECT id_kamera, tgl_kembali FROM transaksi WHERE id_transaksi = ?");
    $stmt_trx->bind_param("i", $trx_id);
    $stmt_trx->execute();
    $trx = $stmt_trx->get_result()->fetch_assoc();
    
    if ($trx) {
        $id_kamera = $trx['id_kamera'];
        $tgl_kembali_seharusnya = $trx['tgl_kembali'];
        
        $denda = 0;
        if (strtotime($tgl_dikembalikan) > strtotime($tgl_kembali_seharusnya)) {
            $selisih_hari = floor((strtotime($tgl_dikembalikan) - strtotime($tgl_kembali_seharusnya)) / (60 * 60 * 24));
            $denda = $selisih_hari * 50000;
        }

        $koneksi->begin_transaction();
        try {
            $update_trx = $koneksi->prepare("UPDATE transaksi SET tgl_dikembalikan = ?, denda = ?, status_sewa = 'Selesai', status_pembayaran = 'Lunas' WHERE id_transaksi = ?");
            $update_trx->bind_param("sdi", $tgl_dikembalikan, $denda, $trx_id);
            $update_trx->execute();

            $update_stok = $koneksi->prepare("UPDATE kamera SET stok = stok + 1 WHERE id_kamera = ?");
            $update_stok->bind_param("s", $id_kamera);
            $update_stok->execute();

            $koneksi->commit();
            
            $pesan = "Kamera berhasil dikembalikan!";
            if ($denda > 0) {
                $pesan .= " Terkena denda keterlambatan Rp " . number_format($denda, 0, ',', '.');
            }
            echo "<script>alert('$pesan'); window.location='halaman_admin.php?open=data_transaksi';</script>";
            exit();
        } catch (Exception $e) {
            $koneksi->rollback();
            echo "<script>alert('Gagal memproses pengembalian: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h2><b>Data Transaksi Sewa</b></h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Kelola riwayat penyewaan kamera, pengembalian, dan status pembayaran.</p>
    </div>
    <a href="halaman_admin.php?open=tambah_transaksi" style="background: var(--primary); color: #111827; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(243, 156, 18, 0.15); flex-shrink: 0;">
        <i data-feather="plus-circle" style="width:16px;"></i> Tambah Sewa
    </a>
</div>

<div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; white-space: nowrap;">
            <thead>
                <tr style="background: #181c2a;">
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color); width: 50px;">No</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">ID TRX</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Pelanggan</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Kamera</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Petugas</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Tgl Sewa</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Tgl Kembali</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Total Harga</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Denda</th>
                    <th style="padding: 15px; text-align: left; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Status</th>
                    <th style="padding: 15px; text-align: center; color: var(--text-muted); font-size: 0.78rem; text-transform: uppercase; border-bottom: 1px solid var(--border-color);">Aksi / Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT t.*, p.nama_pelanggan, k.nama_kamera, k.merk, pt.nama_petugas 
                          FROM transaksi t
                          JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                          JOIN kamera k ON t.id_kamera = k.id_kamera
                          LEFT JOIN petugas pt ON t.id_petugas = pt.id_petugas
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
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); font-weight: 500;"><?php echo htmlspecialchars($data['merk'] . " " . $data['nama_kamera']); ?></td>
                    
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);">
                        <?php echo htmlspecialchars($data['nama_petugas'] ?? '-'); ?>
                    </td>

                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);"><?php echo date('d M Y', strtotime($data['tgl_sewa'])); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); color: var(--text-muted);">
                        <?php echo date('d M Y', strtotime($data['tgl_kembali'])); ?>
                        <?php if (!empty($data['tgl_dikembalikan'])): ?>
                            <br><small style="color: #10b981;">Dikembalikan: <?php echo date('d M Y', strtotime($data['tgl_dikembalikan'])); ?></small>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); font-weight: 600; color: #10b981;">Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></td>
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); font-weight: 600; color: <?php echo ($data['denda'] > 0) ? '#ef4444' : 'var(--text-muted);'; ?>">
                        Rp <?php echo number_format($data['denda'], 0, ',', '.'); ?>
                    </td>
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
                    <td style="padding: 14px 15px; border-bottom: 1px solid var(--border-color); text-align: center;">
                        <div style="display: flex; gap: 6px; justify-content: center; align-items: center;">
                            <?php if ($data['status_sewa'] == 'Berjalan'): ?>
                                <a href="halaman_admin.php?open=data_transaksi&action=kembali&id=<?php echo $data['id_transaksi']; ?>" 
                                   style="background: #10b981; color: #fff; padding: 6px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;"
                                   onclick="return confirm('Selesaikan transaksi ini dan kembalikan kamera ke stok?')">
                                    <i data-feather="check" style="width:12px;"></i> Selesai
                                </a>
                            <?php endif; ?>

                            <!-- Tombol Edit -->
                            <a href="halaman_admin.php?open=edit_transaksi&id=<?php echo $data['id_transaksi']; ?>" 
                               style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; padding: 6px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                                <i data-feather="edit-2" style="width:12px;"></i> Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <a href="hapus_transaksi.php?id=<?php echo $data['id_transaksi']; ?>" 
                               style="background: rgba(239, 68, 68, 0.15); color: #f87171; padding: 6px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;"
                               onclick="return confirm('Yakin ingin menghapus riwayat transaksi ini?')">
                                <i data-feather="trash-2" style="width:12px;"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='11' style='text-align: center; padding: 30px; color: var(--text-muted);'>Belum ada data transaksi penyewaan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>