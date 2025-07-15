<?php
session_start();

// Membatasi akses halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
        alert('Silakan login terlebih dahulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

$title = 'Tambah Mahasiswa';

require 'layout/header.php';

// Proses form
if (isset($_POST['tambah'])) {
    $result = create_mahasiswa($_POST);
    if ($result > 0) {
        echo "<script>
            alert('Data Mahasiswa Berhasil Ditambahkan');
            document.location.href = 'mahasiswa.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Data Mahasiswa Gagal Ditambahkan');
            document.location.href = 'mahasiswa.php';
        </script>";
        exit;
    }
}
?>

<div class="container mt-5">
    <h1>Tambah Mahasiswa</h1>
    <hr>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="prodi" class="form-label">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control" required>
                    <option value="">-- Pilih Prodi --</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                    <option value="Teknik Mesin">Teknik Mesin</option>
                    <option value="Teknik Listrik">Teknik Listrik</option>
                </select>
            </div>
            <div class="mb-3 col-md-6">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-Laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="Nomor Telepon..." pattern="[0-9]{10,15}" title="Nomor telepon hanya angka 10-15 digit" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="3" placeholder="Alamat Mahasiswa..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email Mahasiswa..." required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/png, image/jpeg" onchange="previewImg()" required>
            <img src="assets/img/default.png" alt="Preview Foto" class="img-thumbnail img-preview mt-2" width="150">
        </div>

        <button type="submit" name="tambah" class="btn btn-primary float-end">
            <i class="fas fa-plus"></i> Tambah
        </button>
    </form>
</div>

<script>
    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        if (foto.files && foto.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
            };
            reader.readAsDataURL(foto.files[0]);
        }
    }
</script>

<?php require 'layout/footer.php'; ?>
