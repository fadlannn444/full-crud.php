<?php

session_start();

//Membatasi akses halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
        alert('Login dulu');
        document.location.href = 'login.php';
    </script>";
    exit;
}

//kosong kan $_session user login
$_SESSION = [];

session_unset();
session_destroy();
header("Location: login.php");