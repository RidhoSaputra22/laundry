<?php
require 'koneksi.php';

// Query untuk mengambil data pengeluaran
$query = "SELECT * FROM pengeluaran ORDER BY tanggal DESC";
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

        .table th, .table td {
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
        <h2>Laporan Pengeluaran</h2>
        <p><?= date('d F Y'); ?></p>
    </div>

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
                    <td colspan="4" class="text-center">Tidak ada data pengeluaran</td>
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
