<?php
include_once "../src/koneksi.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    $cek = $koneksi->query("SELECT id_petugas FROM petugas WHERE id_petugas = '$id'");

    if ($cek && $cek->num_rows > 0) {
        $hapus = $koneksi->query("DELETE FROM petugas WHERE id_petugas = '$id'");

        if ($hapus) {
            echo "<script>alert('Data petugas berhasil dihapus!'); window.location='halaman_admin.php?open=data_petugas';</script>";
        } else {
            echo "<script>alert('Gagal menghapus petugas!'); window.location='halaman_admin.php?open=data_petugas';</script>";
        }
    } else {
        echo "<script>alert('Data petugas tidak ditemukan!'); window.location='halaman_admin.php?open=data_petugas';</script>";
    }
} else {
    header("Location: halaman_admin.php?open=data_petugas");
    exit();
}
?>