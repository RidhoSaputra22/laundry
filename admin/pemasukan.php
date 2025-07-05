<?php
$title = 'Data Pemasukan';
require 'koneksi.php';

// Query pemasukan laundry
$query_laundry = "SELECT transaksi.*, pelanggan.nama_pelanggan, pelanggan.telp_pelanggan, detail_transaksi.total_harga FROM transaksi INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan INNER JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi WHERE transaksi.status = 'selesai'";
$data_laundry = mysqli_query($conn, $query_laundry);

// Query untuk mengambil data pemasukan
$query = "SELECT * FROM pemasukan ORDER BY tanggal DESC";
$data = mysqli_query($conn, $query);

require 'header.php';
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div class="flex-grow-1">
                <h2 class="text-white pb-2 fw-bold">Laporan Pemasukan</h2>
            </div>
            <div>
                <a href="cetak_pemasukan.php" target="_blank" class="btn btn-white  btn-round ml-auto shadow-lg ">
                    <i class="fas fa-print"></i>
                    Cetak Laporan Pemasukan
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
                        <h4 class="card-title">Data Pemasukan Laundry</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 7%">#</th>
                                    <th>Kode</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Total</th>
                                    <th style="width: 5%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($data_laundry) > 0) {
                                    while ($trans = mysqli_fetch_assoc($data_laundry)) {
                                ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $trans['kode_invoice']; ?></td>
                                    <td><?= $trans['nama_pelanggan']; ?></td>
                                    <td><?= $trans['status']; ?></td>
                                    <td><?= $trans['status_bayar']; ?></td>
                                    <td><?= 'Rp ' . number_format($trans['total_harga']); ?></td>
                                    <td>
                                        <div class="form-button-action ">
                                            <div class="form-button-action">
                                                <a href="detail.php?id=<?= $trans['id_transaksi']; ?>" type="button"
                                                    data-toggle="tooltip" title="" class="btn btn-primary"
                                                    data-original-title="Detail">
                                                    <i class="far fa-eye"></i> Detail
                                                </a>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                <?php }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                        <h4 class="card-title">Data Pemasukan Lainnya</h4>

                        <a href="tambah_pemasukan.php" class="btn btn-success btn-round ml-auto">
                            <i class="fas fa-plus"></i>
                            Tambah Pemasukan
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
                                        <a href="edit_pemasukan.php?id=<?= $row['id_pemasukan']; ?>"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="hapus_pemasukan.php?id=<?= $row['id_pemasukan']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>


                                </tr>
                                <?php }
                                } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data Pemasukan</td>
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