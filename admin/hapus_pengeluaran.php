<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengamankan input ID
    $query = "DELETE FROM pengeluaran WHERE id_pengeluaran = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['msg'] = "Pengeluaran berhasil dihapus!";
    } else {
        $_SESSION['msg'] = "Gagal menghapus pengeluaran: " . mysqli_error($conn);
    }
} else {
    $_SESSION['msg'] = "ID pengeluaran tidak ditemukan!";
}

header("Location: pengeluaran.php");
exit;
