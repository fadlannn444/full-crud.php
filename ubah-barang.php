<?php

session_start();

// Membatasi akses halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$title = 'Ubah Barang';

include 'layout/header.php';

$id_barang = (int)$_GET['id_barang'];

$barang = select("SELECT * FROM barang WHERE id_barang = $id_barang")[0];

if (isset($_POST['ubah'])) {
    if (update_barang($_POST) > 0) {
        echo "<script>
                    alert('Data Barang Berhasil Diubah');
                    document.location.href = 'index.php'; 
                  </script>";
    } else {
        echo "<script>
                    alert('Data Barang Gagal Diubah');
                    document.location.href = 'index.php';
                  </script>";
    }
}
?>

<div class="container mt-5">
    <h1>Edit Barang</h1>
    <hr>
    <form action="" method="post">
        <input type="hidden" name="id_barang" value="<?= $barang['id_barang'];?>">
        <div class="mb-3">
            <label for="">Nama Barang</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $barang['nama']; ?>"
                placeholder="Masukan nama barang" required>
        </div>
        <div class="mb-3">
            <label for="">Jumlah Barang</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= $barang['jumlah']; ?>"
                placeholder="Masukan jumlah barang" required>
        </div>
        <div class="mb-3">
            <label for="">Harga Barang</label>
            <input type="number" class="form-control" id="harga" name="harga" value="<?= $barang['harga']; ?>"
                placeholder="Masukan jumlah barang" required>
        </div>
        <button type="submit" name="ubah" class="btn btn-success" style="float: right;">Edit</button>
    </form>
</div>

<?php include 'layout/footer.php';?>