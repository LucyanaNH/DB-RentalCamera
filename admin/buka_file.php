<?php
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
    switch($_GET['open']) {
        case 'data_kamera':
            if(!file_exists("data_kamera.php")) die("File Data Kamera tidak ada!");
            include "data_kamera.php"; 
            break;
            
        case 'data_pelanggan':
            if(!file_exists("data_pelanggan.php")) die("File Data Pelanggan tidak ada!");
            include "data_pelanggan.php"; 
            break;
            
        case 'data_transaksi':
            if(!file_exists("data_transaksi.php")) die("File Data Transaksi tidak ada!");
            include "data_transaksi.php"; 
            break;
            
        case 'data_petugas':
            if(!file_exists("data_petugas.php")) die("File Data Petugas tidak ada!");
            include "data_petugas.php"; 
            break;
            
        case 'data_petugas':
            if(!file_exists("data_petugas.php")) die("File Data Petugas tidak ada!");
            include "data_petugas.php"; 
            break;
            
        // TAMBAHKAN BAGIAN INI:
        case 'tambah_transaksi':
            if(!file_exists("tambah_transaksi.php")) die("File Tambah Transaksi tidak ada!");
            include "tambah_transaksi.php"; 
            break;
            
        default:
            if(!file_exists("informasi_utama.php")) die("File Informasi Utama tidak ada!");
            include "informasi_utama.php"; 
            break;
    }
}
else {
    // Jika tidak ada parameter ?open di URL, tampilkan halaman utama
    if(!file_exists("informasi_utama.php")) die("File Informasi Utama tidak ada!");
    include "informasi_utama.php";
}
?>