<?php

session_start();

// Cek login
if (!isset($_SESSION["login"])) {
    echo "<script>
           alert('Login dulu');
           document.location.href = 'login.php';
           </script>";
    exit;
}

// Cek level akses
if ($_SESSION["level"] != 1 && $_SESSION["level"] != 3) {
    echo "<script>
           alert('Perhatian! Anda tidak punya hak akses');
           document.location.href = 'crud-modal.php';
           </script>";
    exit;
}

// Aktifkan output buffering
ob_start();

require __DIR__ . '/vendor/autoload.php';
require 'config/app.php';

use Spipu\Html2Pdf\Html2Pdf;

// Ambil data
$data_barang = select("SELECT * FROM mahasiswa");

// Inisialisasi $content
$content = '';

$content .= '<style type="text/css">
    .gambar {
        width: 50px;
    }
</style>';

$content .= '
<page>
    <h3 align="center">Laporan Data Mahasiswa</h3>
    <table border="1" align="center" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Jenis Kelamin</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>Foto</th>
        </tr>';

$no = 1;
foreach ($data_barang as $barang) {
    $content .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . htmlspecialchars($barang['nama']) . '</td>
            <td>' . htmlspecialchars($barang['prodi']) . '</td>
            <td>' . htmlspecialchars($barang['jk']) . '</td>
            <td>' . htmlspecialchars($barang['telepon']) . '</td>
            <td>' . htmlspecialchars($barang['email']) . '</td>
            <td><img src="assets/img/' . htmlspecialchars($barang['foto']) . '" class="gambar"></td>
        </tr>';
}

$content .= '
    </table>
</page>';

// Generate PDF
$html2pdf = new Html2Pdf();
$html2pdf->writeHTML($content);
$html2pdf->output('Laporan-mahasiswa.pdf');
