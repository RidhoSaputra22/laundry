<?php
require 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama_pelanggan, detail_transaksi.*, outlet.nama_outlet, paket_cuci.nama_paket FROM transaksi INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan INNER JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN outlet ON outlet.id_outlet = transaksi.outlet_id INNER JOIN paket_cuci ON paket_cuci.outlet_id = transaksi.outlet_id WHERE transaksi.id_transaksi = '$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .nota {
            width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .nota h1 {
            text-align: center;
        }
        .nota table {
            width: 100%;
            border-collapse: collapse;
        }
        .nota table th, .nota table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .nota .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="nota">
        <h1>Nota Pembayaran</h1>
        <p>Kode Invoice: <?= $data['kode_invoice']; ?></p>
        <p>Outlet: <?= $data['nama_outlet']; ?></p>
        <p>Pelanggan: <?= $data['nama_pelanggan']; ?></p>
        <table>
            <tr>
                <th>Jenis Paket</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
            <tr>
                <td><?= $data['nama_paket']; ?></td>
                <td><?= $data['qty']; ?></td>
                <td>Rp<?= number_format($data['total_harga'], 0, ',', '.'); ?></td>
            </tr>
        </table>
        <p>Total Bayar: Rp<?= number_format($data['total_bayar'], 0, ',', '.'); ?></p>
        <p>Tanggal Pembayaran: <?= $data['tgl_pembayaran'] ?: 'Belum Dibayar'; ?></p>
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami!</p>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
