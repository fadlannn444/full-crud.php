<?php
session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
           alert('login dulu');
           document.location.href = 'login.php';
           </script>";
    exit;
}

if ($_SESSION["level"] != 1 and $_SESSION["level"] != 3) {
    echo "<script>
           alert('Perhatian anda tidak punya hak akses');
           document.location.href = 'crud-modal.php';
           </script>";
    exit;
}

$title = 'Daftar Mahasiswa';

include 'layout/header.php';

$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");

// Ambil data untuk grafik: jumlah mahasiswa per prodi
$data_prodi = select("SELECT prodi, COUNT(*) as jumlah FROM mahasiswa GROUP BY prodi");

// Siapkan data untuk Chart.js
$labels = [];
$jumlah = [];

foreach ($data_prodi as $prodi) {
    $labels[] = $prodi['prodi'];
    $jumlah[] = $prodi['jumlah'];
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-users"></i> Data Mahasiswa</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Grafik Mahasiswa per Prodi -->
    <div class="container-fluid mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafik Mahasiswa per Prodi</h3>
            </div>
            <div class="card-body">
                <canvas id="chartProdi" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Data Mahasiswa -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Data Mahasiswa</h3>
        </div>
        <!-- /.card-header-->
        <div class="card-body">
            <hr>
            <a href="tambah-mahasiswa.php" class="btn btn-primary mb-1"><i class="fas fa-plus-circle"></i> Tambah</a>
            <a href="download-excel-mahasiswa.php" class="btn btn-success mb-1"><i class="fas fa-file-excel"></i> Download Excel</a>
            <a href="download-pdf-mahasiswa.php" class="btn btn-danger mb-1"><i class="fas fa-file-pdf"></i> Download PDF</a>
            <table id="serverside" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($data_mahasiswa as $mahasiswa) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($mahasiswa['nama']); ?></td>
                            <td><?= htmlspecialchars($mahasiswa['prodi']); ?></td>
                            <td><?= htmlspecialchars($mahasiswa['jk']); ?></td>
                            <td><?= htmlspecialchars($mahasiswa['telepon']); ?></td>
                            <td>
                                <a href="ubah-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                <a href="hapus-mahasiswa.php?id_mahasiswa=<?= $mahasiswa['id_mahasiswa']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartProdi').getContext('2d');
    const chartProdi = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels); ?>,
            datasets: [{
                label: 'Jumlah Mahasiswa',
                data: <?= json_encode($jumlah); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Jumlah Mahasiswa per Prodi' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

<?php include 'layout/footer.php'; ?>
