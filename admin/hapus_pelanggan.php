<?php
include_once "../src/koneksi.php";

// Pastikan parameter ID ada dan tidak kosong/null
if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // PENGAMAN EKSTRA: Jangan biarkan menghapus jika ID kosong string
    if ($id == "") {
        echo "<script>
            alert('ID Pelanggan tidak valid!');
            window.location='halaman_admin.php?open=data_pelanggan';
        </script>";
        exit;
    }

    // Eksekusi hapus hanya untuk 1 ID spesifik tersebut
    $query = mysqli_query(
        $koneksi,
        "DELETE FROM pelanggan WHERE id_pelanggan = '$id'"
    );

    if ($query) {
        echo "<script>
            alert('Pelanggan berhasil dihapus!');
            window.location='halaman_admin.php?open=data_pelanggan';
        </script>";
    } else {
        echo "<script>
            alert('Pelanggan gagal dihapus! Pastikan pelanggan tidak sedang terikat dengan data transaksi.');
            window.location='halaman_admin.php?open=data_pelanggan';
        </script>";
    }

} else {
    // Jika tidak ada ID yang dibawa sama sekali, tolak dan kembalikan
    echo "<script>
        alert('Aksi tidak sah! ID tidak ditemukan.');
        window.location='halaman_admin.php?open=data_pelanggan';
    </script>";
    exit;
}
?>