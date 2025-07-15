<?php 

session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
           alert('login dulu');
           document.location.href = 'login.php';
           </script>";
    exit;
}

$title = 'Tambah Barang';

    include 'layout/header.php'; 

    if (isset($_POST['tambah'])) {
        if (create_barang($_POST) > 0) {
            echo "<script>
                    alert('Data Barang Berhasil Ditambahkan');
                    document.location.href = 'index.php'; 
                  </script>";
        } else {
            echo "<script>
                    alert('Data Barang Gagal Ditambahkan');
                    document.location.href = 'index.php';
                  </script>";
        }
    }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container mt-5">
    <h1>Tambah Data Barang</h1>
    <hr>
    <form action="" method="post">
        <div class="mb-3">
            <label for="">Nama Barang</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan nama barang" required>
        </div>
        <div class="mb-3">
            <label for="">Jumlah Barang</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukan jumlah barang" required>
        </div>
        <div class="mb-3">
            <label for="">Harga Barang</label>
            <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukan harga barang" required>
        </div>
        <input type="submit" name="tambah" class="btn btn-success" style="float: right;" value="Tambah">
    </form>
</div>
</div>

<?php include 'layout/footer.php'; ?>