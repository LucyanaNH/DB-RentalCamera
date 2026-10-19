<?php

include_once "../src/koneksi.php";


/* =========================
   CEK ID
   ========================= */

if (!isset($_GET['id']) || empty($_GET['id'])) {

    echo "<script>
            alert('ID kamera tidak ditemukan!');
            window.location='halaman_admin.php?open=data_kamera';
          </script>";

    exit;
}


$id = mysqli_real_escape_string(
    $koneksi,
    $_GET['id']
);


/* =========================
   CEK DATA
   ========================= */

$cek = $koneksi->query(
    "SELECT id_kamera
     FROM kamera
     WHERE id_kamera = '$id'"
);


if ($cek->num_rows == 0) {

    echo "<script>
            alert('Data kamera tidak ditemukan!');
            window.location='halaman_admin.php?open=data_kamera';
          </script>";

    exit;
}


/* =========================
   HAPUS DATA
   ========================= */

$sql = "DELETE FROM kamera
        WHERE id_kamera = '$id'";


if ($koneksi->query($sql)) {

    echo "<script>
            alert('Data kamera berhasil dihapus!');
            window.location='halaman_admin.php?open=data_kamera';
          </script>";

} else {

    echo "<script>
            alert('Gagal menghapus kamera: " .
            addslashes($koneksi->error) .
            "');

            window.location='halaman_admin.php?open=data_kamera';
          </script>";
}

exit;
?>

