<?php
require 'koneksi.php';

$query_laundry = "SELECT transaksi.*, pelanggan.nama_pelanggan, detail_transaksi.total_harga, outlet.nama_outlet FROM transaksi INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan INNER JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi INNER JOIN outlet ON outlet.id_outlet = transaksi.outlet_id";
$data_laundry = mysqli_query($conn, $query_laundry);


// Query untuk mengambil data pengeluaran
$query = "SELECT * FROM pemasukan ORDER BY tanggal DESC";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengeluaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Laporan Pemasukan</h2>
        <p><?= date('d F Y'); ?></p>
    </div>
    <h1>Pemasukan Laundry</h1>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 3%">#</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Nama Pelanggan</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Outlet Pembayaran</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            if (mysqli_num_rows($data_laundry) > 0) {
                while ($trans = mysqli_fetch_assoc($data_laundry)) {
                    $total += $trans['total_harga'];
            ?>

                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $trans['tgl']; ?></td>
                        <td><?= $trans['kode_invoice']; ?></td>
                        <td><?= $trans['nama_pelanggan']; ?></td>
                        <td><?= $trans['status']; ?></td>
                        <td><?= $trans['status_bayar']; ?></td>
                        <td><?= $trans['nama_outlet']; ?></td>
                        <td><?= 'Rp ' . number_format($trans['total_harga']); ?></td>
                    </tr>
            <?php }
            } else {
                echo "<tr><td colspan='7' class='text-center'>Tidak ada data laundry</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7" class="text-right">Total</th>
                <th class="text-right"><?= 'Rp ' . number_format($total); ?></th>
            </tr>
        </tfoot>
    </table>

    <h1>Pemasukan Lainnya</h1>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $total = 0;
            if (mysqli_num_rows($data) > 0) {
                while ($row = mysqli_fetch_assoc($data)) {
                    $total += $row['jumlah'];
            ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= $row['keterangan']; ?></td>
                        <td class="text-right"><?= 'Rp ' . number_format($row['jumlah']); ?></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data pemasukan</td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-right">Total</th>
                <th class="text-right"><?= 'Rp ' . number_format($total); ?></th>
            </tr>
        </tfoot>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>