<?php
include_once "../src/koneksi.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_transaksi = intval($_GET['id']);

    // Cek apakah transaksi ada
    $cek = $koneksi->query("SELECT id_transaksi FROM transaksi WHERE id_transaksi = $id_transaksi");
    
    if ($cek && $cek->num_rows > 0) {
        $hapus = $koneksi->query("DELETE FROM transaksi WHERE id_transaksi = $id_transaksi");

        if ($hapus) {
            echo "<script>
                    alert('Data transaksi berhasil dihapus!');
                    window.location='halaman_admin.php?open=data_transaksi';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal menghapus transaksi!');
                    window.location='halaman_admin.php?open=data_transaksi';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Data transaksi tidak ditemukan!');
                window.location='halaman_admin.php?open=data_transaksi';
              </script>";
    }
} else {
    header("Location: halaman_admin.php?open=data_transaksi");
    exit();
}
?>