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

$title = 'Ubah Mahasiswa';

include 'layout/header.php';

// Validasi ID mahasiswa di URL
if (!isset($_GET['id_mahasiswa'])) {
    echo "<script>
        alert('ID Mahasiswa tidak ditemukan');
        document.location.href = 'mahasiswa.php';
    </script>";
    exit;
}

$id_mahasiswa = (int) $_GET['id_mahasiswa'];

// Query ambil data mahasiswa
$mahasiswa = select("SELECT * FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa");
if (empty($mahasiswa)) {
    echo "<script>
        alert('Data Mahasiswa tidak ditemukan');
        document.location.href = 'mahasiswa.php';
    </script>";
    exit;
}
$mahasiswa = $mahasiswa[0];

// Handle submit
if (isset($_POST['ubah'])) {
    if (update_mahasiswa($_POST) > 0) {
        echo "<script>
            alert('Data Mahasiswa Berhasil Diubah');
            document.location.href = 'mahasiswa.php'; 
        </script>";
    } else {
        echo "<script>
            alert('Data Mahasiswa Gagal Diubah');
            document.location.href = 'mahasiswa.php';
        </script>";
    }
}
?>
<div class="content-wrapper">
<section class="content"></section>
<div class="container mt-5">
    <h1>Ubah Mahasiswa</h1>
    <hr>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_mahasiswa" value="<?= $mahasiswa['id_mahasiswa']; ?>">
        <input type="hidden" name="fotolama" value="<?= htmlspecialchars($mahasiswa['foto']); ?>">

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mahasiswa</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Mahasiswa..." required
                value="<?= htmlspecialchars($mahasiswa['nama']); ?>">
        </div>

        <div class="row">
            <div class="mb-3 col-6">
                <label for="prodi" class="form-label">Program Studi</label>
                <select name="prodi" id="prodi" class="form-control" required>
                    <?php $prodi = $mahasiswa['prodi']; ?>
                    <option value="Teknik Informatika" <?= $prodi == 'Teknik Informatika' ? 'selected' : ''; ?>>Teknik Informatika</option>
                    <option value="Teknik Mesin" <?= $prodi == 'Teknik Mesin' ? 'selected' : ''; ?>>Teknik Mesin</option>
                    <option value="Teknik Listrik" <?= $prodi == 'Teknik Listrik' ? 'selected' : ''; ?>>Teknik Listrik</option>
                </select>
            </div>
            <div class="mb-3 col-6">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select name="jk" id="jk" class="form-control" required>
                    <?php $jk = $mahasiswa['jk']; ?>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-Laki" <?= $jk == 'Laki-Laki' ? 'selected' : ''; ?>>Laki-Laki</option>
                    <option value="Perempuan" <?= $jk == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">Telepon</label>
            <input type="number" class="form-control" id="telepon" name="telepon" placeholder="Telepon..." required
                value="<?= htmlspecialchars($mahasiswa['telepon']); ?>">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat"><?= htmlspecialchars($mahasiswa['alamat']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email..." required
                value="<?= htmlspecialchars($mahasiswa['email']); ?>">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto">

            <p><small>Gambar Sebelumnya:</small></p>
            <img src="assets/img/<?= htmlspecialchars($mahasiswa['foto']); ?>" alt="Foto Mahasiswa" width="200">
        </div>

        <button type="submit" name="ubah" class="btn btn-primary float-end">
            <i class="fas fa-save"></i> Ubah
        </button>
    </form>
</div>
<section class="content"></section>
</div>
<?php include 'layout/footer.php'; ?>
