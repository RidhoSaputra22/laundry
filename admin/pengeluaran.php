<?php
$title = 'Data Pengeluaran';
require 'koneksi.php';

// Query untuk mengambil data pengeluaran
$query = "SELECT * FROM pengeluaran ORDER BY tanggal DESC";
$data = mysqli_query($conn, $query);

require 'header.php';
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div class="flex-grow-1">
                <h2 class="text-white pb-2 fw-bold">Laporan Pengeluaran</h2>
            </div>
            <div>
                <a href="cetak_pengeluaran.php" target="_blank" class="btn btn-white btn-round ml-auto shadow-lg ">
                    <i class="fas fa-print"></i>
                    Cetak Laporan Pengeluaran
                </a>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title"><?= $title; ?></h4>

                        <a href="tambah_pengeluaran.php" class="btn btn-success btn-round ml-auto">
                            <i class="fas fa-plus"></i>
                            Tambah Pengeluaran
                        </a>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                                ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                            <td><?= $row['keterangan']; ?></td>
                                            <td><?= 'Rp ' . number_format($row['jumlah']); ?></td>
                                            <td>
                                                <a href="edit_pengeluaran.php?id=<?= $row['id_pengeluaran']; ?>"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="hapus_pengeluaran.php?id=<?= $row['id_pengeluaran']; ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </a>
                                            </td>


                                        </tr>
                                    <?php }
                                } else { ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data pengeluaran</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';
?>