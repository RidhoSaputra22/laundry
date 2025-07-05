<?php
$title = 'Tambah Pengeluaran';
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);

    $query = "INSERT INTO pengeluaran (tanggal, keterangan, jumlah) VALUES ('$tanggal', '$keterangan', '$jumlah')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['msg'] = "Pengeluaran berhasil ditambahkan!";
        header("Location: pengeluaran.php");
        exit;
    } else {
        $_SESSION['msg'] = "Gagal menambahkan pengeluaran: " . mysqli_error($conn);
    }
}

require 'header.php';
?>

<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Tambah Pengeluaran</h2>
            </div>
        </div>
    </div>
</div>
<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <?php if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') { ?>
                        <div class="alert alert-info">
                            <?= $_SESSION['msg']; ?>
                        </div>
                    <?php 
                    $_SESSION['msg'] = ''; 
                    } ?>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan keterangan" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan jumlah pengeluaran" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="pengeluaran.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require 'footer.php';
?>
