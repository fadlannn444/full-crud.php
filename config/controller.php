<?php

// Pastikan koneksi database $db sudah dibuat di file ini atau di-include sebelum fungsi dipanggil

// ──────────────────────────────────────
// FUNGSI SELECT
// ──────────────────────────────────────

function select($query)
{
    global $db;
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// ──────────────────────────────────────
// FUNGSI BARANG
// ──────────────────────────────────────

function create_barang($post)
{
    global $db;
    $nama = mysqli_real_escape_string($db, $post['nama']);
    $jumlah = (int)$post['jumlah'];
    $harga = (float)$post['harga'];
    $barcode = rand(100000, 999999);

    $query = "INSERT INTO barang (nama, jumlah, harga, barcode, created_at) 
              VALUES ('$nama', '$jumlah', '$harga', '$barcode', CURRENT_TIMESTAMP())";

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function update_barang($post)
{
    global $db;
    $id_barang = (int)$post['id_barang'];
    $nama = mysqli_real_escape_string($db, $post['nama']);
    $jumlah = (int)$post['jumlah'];
    $harga = (float)$post['harga'];

    $query = "UPDATE barang 
              SET nama='$nama', jumlah='$jumlah', harga='$harga' 
              WHERE id_barang = $id_barang";

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function delete_barang($id_barang)
{
    global $db;
    $id_barang = (int)$id_barang;

    $query = "DELETE FROM barang WHERE id_barang = $id_barang";
    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

// ──────────────────────────────────────
// FUNGSI MAHASISWA
// ──────────────────────────────────────

function create_mahasiswa($post)
{
    global $db;
    $nama = mysqli_real_escape_string($db, $post['nama']);
    $prodi = mysqli_real_escape_string($db, $post['prodi']);
    $jk = mysqli_real_escape_string($db, $post['jk']);
    $telepon = mysqli_real_escape_string($db, $post['telepon']);
    $alamat = mysqli_real_escape_string($db, $post['alamat']);
    $email = mysqli_real_escape_string($db, $post['email']);

    $foto = upload_file();
    if (!$foto) {
        return false;
    }

    $query = "INSERT INTO mahasiswa (nama, prodi, jk, telepon, email, foto, alamat)
              VALUES ('$nama', '$prodi', '$jk', '$telepon', '$email', '$foto', '$alamat')";

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function update_mahasiswa($post)
{
    global $db;
    $id_mahasiswa = (int)$post['id_mahasiswa'];
    $nama = mysqli_real_escape_string($db, $post['nama']);
    $prodi = mysqli_real_escape_string($db, $post['prodi']);
    $jk = mysqli_real_escape_string($db, $post['jk']);
    $telepon = mysqli_real_escape_string($db, $post['telepon']);
    $alamat = mysqli_real_escape_string($db, $post['alamat']);
    $email = mysqli_real_escape_string($db, $post['email']);
    $fotolama = mysqli_real_escape_string($db, $post['fotolama']);

    if ($_FILES['foto']['error'] === 4) {
        $foto = $fotolama;
    } else {
        $foto = upload_file();
        if (!$foto) {
            return false;
        }
    }

    $query = "UPDATE mahasiswa 
              SET nama='$nama', prodi='$prodi', jk='$jk', telepon='$telepon', 
                  alamat='$alamat', email='$email', foto='$foto' 
              WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function delete_mahasiswa($id_mahasiswa)
{
    global $db;
    $id_mahasiswa = (int)$id_mahasiswa;

    $mahasiswa = select("SELECT foto FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa");
    if ($mahasiswa && $mahasiswa[0]['foto']) {
        $filePath = 'assets/img/' . $mahasiswa[0]['foto'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";
    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function upload_file()
{
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    $extensiValid = ['jpg', 'jpeg', 'png'];
    $extensiFile = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($extensiFile, $extensiValid)) {
        echo "<script>alert('Format file tidak valid (hanya jpg/jpeg/png)');document.location.href='tambah-mahasiswa.php';</script>";
        return false;
    }

    if ($ukuranFile > 2 * 1024 * 1024) {
        echo "<script>alert('Ukuran file terlalu besar (maks 2MB)');document.location.href='tambah-mahasiswa.php';</script>";
        return false;
    }

    $namaFileBaru = uniqid() . '.' . $extensiFile;
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}

// ──────────────────────────────────────
// FUNGSI AKUN
// ──────────────────────────────────────

function create_akun($post)
{
    global $db;
    $nama = mysqli_real_escape_string($db, strip_tags($post['nama']));
    $username = mysqli_real_escape_string($db, strip_tags($post['username']));
    $email = mysqli_real_escape_string($db, strip_tags($post['email']));
    $password = password_hash(strip_tags($post['password']), PASSWORD_DEFAULT);
    $level = mysqli_real_escape_string($db, strip_tags($post['level']));

    $query = "INSERT INTO akun (nama, username, email, password, level) 
              VALUES ('$nama', '$username', '$email', '$password', '$level')";

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function update_akun($post)
{
    global $db;
    $id_akun = (int)$post['id_akun'];
    $nama = mysqli_real_escape_string($db, strip_tags($post['nama']));
    $username = mysqli_real_escape_string($db, strip_tags($post['username']));
    $email = mysqli_real_escape_string($db, strip_tags($post['email']));
    $password = password_hash(strip_tags($post['password']), PASSWORD_DEFAULT);
    $level = mysqli_real_escape_string($db, strip_tags($post['level']));

    $query = "UPDATE akun 
              SET nama='$nama', username='$username', email='$email', password='$password', level='$level' 
              WHERE id_akun = $id_akun";

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}

function delete_akun($id_akun)
{
    global $db;
    $id_akun = (int)$id_akun;

    $query = "DELETE FROM akun WHERE id_akun = $id_akun";
    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}
