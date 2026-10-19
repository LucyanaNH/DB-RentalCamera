<?php
include_once "../src/koneksi.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    $cek = $koneksi->query("SELECT id_kategori FROM kategori_pelanggan WHERE id_kategori = '$id'");

    if ($cek && $cek->num_rows > 0) {
        $hapus = $koneksi->query("DELETE FROM kategori_pelanggan WHERE id_kategori = '$id'");

        if ($hapus) {
            echo "<script>alert('Kategori berhasil dihapus!'); window.location='halaman_admin.php?open=data_kategori';</script>";
        } else {
            echo "<script>alert('Gagal menghapus kategori! Pastikan kategori tidak sedang digunakan oleh pelanggan.'); window.location='halaman_admin.php?open=data_kategori';</script>";
        }
    } else {
        echo "<script>alert('Data kategori tidak ditemukan!'); window.location='halaman_admin.php?open=data_kategori';</script>";
    }
} else {
    header("Location: halaman_admin.php?open=data_kategori");
    exit();
}
?>