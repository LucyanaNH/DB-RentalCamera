<?php
include_once "src/koneksi.php";

if(isset($_POST['btnBayar'])){
    $id_transaksi = $_POST['id_transaksi'];
    $metode = $_POST['metode_pembayaran']; // Metode bank/qris yang dipilih
    
    // Asumsi kita punya kolom 'status_bayar' di tabel transaksi_sewa
    // Kita update data tersebut!
    $sql = mysqli_query($koneksi, "UPDATE transaksi_sewa 
                                   SET status_bayar = 'Lunas - $metode' 
                                   WHERE id_transaksi = '$id_transaksi'");
                                   
    if($sql) {
        // Tampilkan pesan sukses ala alert Javascript
        echo "<script>
                alert('Pembayaran sebesar Rp " . number_format($total, 0) . " menggunakan $metode BERHASIL!');
                window.location='halaman_pelanggan.php?id_transaksi=$id_transaksi';
              </script>";
    } else {
        echo "<script>alert('Pembayaran Gagal!');</script>";
    }
}
?>