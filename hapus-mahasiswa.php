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

include 'config/app.php';

// menerima id barang yang dipilih pengguna
$id_mahasiswa = (int) $_GET['id_mahasiswa'];

if (delete_mahasiswa($id_mahasiswa) > 0) {
    echo "<script>
         alert('Data mahasiswa Berhasil Dihapus');
         document.location.href = 'mahasiswa.php'; 
         </script>";
} else {
    echo "<script>
          alert('Data mahasiswa Gagal Dihapus');
          document.location.href = 'mahasiswa.php';
    </script>";
}

function delete_mahasiswa($id_mahasiswa)
{
    global $db;

    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = $id_mahasiswa";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}