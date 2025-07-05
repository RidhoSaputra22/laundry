<?php
session_start();
include '../config/conn.php';

if ($_SESSION) {
    if ($_SESSION['role'] == 'admin') {
    } else {
        header("location:../login.php");
    }
} else {
    header('location:../login.php');
}

$conn = $conn;

if (mysqli_connect_error()) {
    echo "Koneksi ke database gagal : " . mysqli_connect_error();
}

function chat_pelanggan($data)
{

    $pesan = "Halo $data[nama_pelanggan],\n\n"
        . "Pesanan laundry Anda sudah selesai dan siap diambil.\n\n"
        . "Status Pembayaran: $data[status_bayar]\n"
        . "Total Pembayaran: Rp " . number_format($data['total_harga'], 0, ',', '.') . "\n\n"
        . "Jam operasional: 08.00 - 20.00 WIB\n\n"
        . "Mohon segera diambil agar tidak menumpuk ya.\n\n"
        . "Terima kasih telah menggunakan layanan Mahamah";

    return urlencode($pesan);
}
