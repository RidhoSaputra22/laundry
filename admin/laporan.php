<?php
$title = 'Data Laporan';
require 'koneksi.php';

$query = "SELECT transaksi.*, pelanggan.nama_pelanggan, detail_transaksi.total_harga, outlet.nama_outlet 
FROM transaksi 
INNER JOIN pelanggan ON pelanggan.id_pelanggan = transaksi.id_pelanggan 
INNER JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi 
INNER JOIN outlet ON outlet.id_outlet = transaksi.outlet_id";

if (isset($_GET['pilihan'])) {
    $pilihan = $_GET['pilihan'];
    $hari = $_GET['hari'] ?? 0;
    $bulan = $_GET['bulan'] ?? 0;
    $tahun = $_GET['tahun'] ?? 0;
    switch ($pilihan) {
        case 1:
            $date_form = date_format(date_create($tahun . '-' . $bulan . '-' . $hari), 'Y-m-d H:i:s');
            $date_to = date_format(date_create($tahun . '-' . $bulan . '-' . $hari + 1), 'Y-m-d H:i:s');
            $query .= " WHERE DATE(tgl) >= '$date_form' AND DATE(tgl) < '$date_to'";
            break;
        case 2:
            $date_form = date_format(date_create($tahun . '-' . $bulan . '-01'), 'Y-m-d H:i:s');
            $date_to = date_format(date_create($tahun . '-' . $bulan + 1 . '-01'), 'Y-m-d H:i:s');
            $query .= " WHERE DATE(tgl) >= '$date_form' AND DATE(tgl) < '$date_to'";
            break;
        case 3:
            $date_form = date_format(date_create($tahun . '-01-01'), 'Y-m-d H:i:s');
            $date_to = date_format(date_create($tahun + 1 . '-01-01'), 'Y-m-d H:i:s');
            $query .= " WHERE DATE(tgl) >= '$date_form' AND DATE(tgl) < '$date_to'";
            break;
    }
}



$data = mysqli_query($conn, $query);

require 'header.php';
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
            </div>
        </div>
        <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] <> '') { ?>
        <div class="alert alert-success" role="alert" id="msg">
            <?= $_SESSION['msg']; ?>
        </div>
        <?php }
        $_SESSION['msg'] = ''; ?>
    </div>
</div>
<div class="page-inner mt--5">

    <diva class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-end">
                        <h4 class="card-title flex-grow-1"><?= $title; ?></h4>
                        <a href="cetak.php" target="_blank" class="btn btn-primary btn-round ">
                            <i class="fas fa-print"></i>
                            Cetak Laporan
                        </a>
                        <a href="pengeluaran.php" class="btn btn-secondary btn-round ml-2">
                            <i class="fas fa-coins"></i>
                            Data Pengeluaran
                        </a>
                        <div>
                            <form action="" class>
                                <div class="mt-2 d-flex justify-content-evenly align-items-end">
                                    <div class="ml-3">
                                        <label class="form-label">Pilihan</label>
                                        <select name="pilihan" id="" class="form-control" style="width: 200px; ">
                                            <option value="1" <?= ($_GET['pilihan'] ?? 0) == 1 ? "selected" : "" ?>>
                                                Harian
                                            </option>
                                            <option value="2" <?= ($_GET['pilihan'] ?? 0) == 2 ? "selected" : "" ?>>
                                                Bulanan
                                            </option>
                                            <option value="3" <?= ($_GET['pilihan'] ?? 0) == 3 ? "selected" : "" ?>>
                                                Tahunan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="ml-3">
                                        <label class="form-label">Hari (1 - 31)</label>
                                        <input type="number" name="hari" id="" value="<?= $_GET['hari'] ?? 0 ?>" min="1"
                                            max="31" class="form-control" style="width: 200px; "
                                            <?= ($_GET['pilihan'] ?? 0) == 1 ? "" : "disabled" ?>>
                                    </div>
                                    <div class="ml-3">
                                        <label for="bulan" class="form-label">Bulan</label>
                                        <select name="bulan" id="" class="form-control" style="width: 200px; "
                                            <?= ($_GET['pilihan'] ?? 0) == 2 ? "" : "disabled" ?>>
                                            <option value="1" <?= ($_GET['bulan'] ?? 0) == 1 ? "selected" : "" ?>>
                                                January
                                            </option>
                                            <option value="2" <?= ($_GET['bulan'] ?? 0) == 2 ? "selected" : "" ?>>
                                                February
                                            </option>
                                            <option value="3" <?= ($_GET['bulan'] ?? 0) == 3 ? "selected" : "" ?>>March
                                            </option>
                                            <option value="4" <?= ($_GET['bulan'] ?? 0) == 4 ? "selected" : "" ?>>April
                                            </option>
                                            <option value="5" <?= ($_GET['bulan'] ?? 0) == 5 ? "selected" : "" ?>>May
                                            </option>
                                            <option value="6" <?= ($_GET['bulan'] ?? 0) == 6 ? "selected" : "" ?>>June
                                            </option>
                                            <option value="7" <?= ($_GET['bulan'] ?? 0) == 7 ? "selected" : "" ?>>July
                                            </option>
                                            <option value="8" <?= ($_GET['bulan'] ?? 0) == 8 ? "selected" : "" ?>>August
                                            </option>
                                            <option value="9" <?= ($_GET['bulan'] ?? 0) == 9 ? "selected" : "" ?>>
                                                September
                                            </option>
                                            <option value="10" <?= ($_GET['bulan'] ?? 0) == 10 ? "selected" : "" ?>>
                                                October
                                            </option>
                                            <option value="11" <?= ($_GET['bulan'] ?? 0) == 11 ? "selected" : "" ?>>
                                                November
                                            </option>
                                            <option value="12" <?= ($_GET['bulan'] ?? 0) == 12 ? "selected" : "" ?>>
                                                December
                                            </option>
                                        </select>
                                    </div>
                                    <div class="ml-3">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" id="" class="form-control" style="width: 200px; ">
                                            <?php foreach (range(date('Y') - 10, date('Y') + 10) as $tahun) { ?><option
                                                value="<?= $tahun ?>"
                                                <?= $tahun == ($_GET['tahun'] ?? date('Y')) ? 'selected' : '' ?>>
                                                <?= $tahun ?>
                                            </option><?php }  ?>
                                        </select>
                                    </div>

                                    <div class="ml-3">
                                        <button class="btn btn-warning d-inline ">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

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
                                    <th>Outlet Pembayaran</th>
                                    <th>Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                if (mysqli_num_rows($data) > 0) {
                                    while ($trans = mysqli_fetch_assoc($data)) {
                                ?>

                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $trans['kode_invoice']; ?></td>
                                    <td><?= $trans['nama_pelanggan']; ?></td>
                                    <td><?= $trans['status']; ?></td>
                                    <td><?= $trans['status_bayar']; ?></td>
                                    <td><?= 'Rp ' . number_format($trans['total_harga']); ?></td>
                                    <td><?= $trans['nama_outlet']; ?></td>
                                    <td><?= $trans['tgl']; ?></td>
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
<?php
require 'footer.php';
?>