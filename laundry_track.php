<?php
// laundry_track.php
header('Content-Type: application/json');
include 'config/conn.php';
$phone = convertToIndoPhoneFormat($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';

// Contoh validasi login sederhana
$query = "SELECT * FROM pelanggan WHERE telp_pelanggan = '$phone' AND password = '$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $id_pelanggan = mysqli_fetch_assoc($result)['id_pelanggan'];
    $data = mysqli_query($conn, "SELECT * FROM transaksi WHERE id_pelanggan = '$id_pelanggan'");

    echo json_encode([
        'success' => true,
        'id_pelanggan' => $id_pelanggan,
        'data' => [
            'transaksi' => mysqli_fetch_all($data, MYSQLI_ASSOC)
        ]
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Nomor telepon atau password salah.'
    ]);
    exit;
}
