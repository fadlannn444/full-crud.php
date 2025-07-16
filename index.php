<?php
session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
           alert('login dulu');
           document.location.href = 'login.php';
           </script>";
    exit;
}

if ($_SESSION["level"] != 1 and $_SESSION["level"] != 2) {
    echo "<script>
           alert('Perhatian anda tidak punya hak akses');
           document.location.href = 'crud-modal.php';
           </script>";
    exit;
}

$title = 'Daftar Barang';

include 'layout/header.php';


// Grafik 1: Jumlah total barang per tanggal
$grafik_data = select("SELECT DATE(tanggal) as tanggal, SUM(jumlah) as total_jumlah 
                       FROM barang 
                       GROUP BY DATE(tanggal) 
                       ORDER BY tanggal ASC");

$labels1 = [];
$data1 = [];
foreach ($grafik_data as $row) {
    $labels1[] = $row['tanggal'];
    $data1[] = $row['total_jumlah'];
}

// Grafik 2: Top 10 barang berdasarkan jumlah
$grafik_barang = select("SELECT nama, SUM(jumlah) as total_jumlah 
                         FROM barang 
                         GROUP BY nama 
                         ORDER BY total_jumlah DESC 
                         LIMIT 10");

$labels2 = [];
$data2 = [];
foreach ($grafik_barang as $row) {
    $labels2[] = $row['nama'];
    $data2[] = $row['total_jumlah'];
}

// Tabel & filter
if (isset($_POST['filter'])) {
    $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
    $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");
    $data_barang = select("SELECT * FROM barang WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_barang DESC");
} else {
    $jumlahDataPerhalaman = 5;
    $jumlahData = count(select("SELECT * FROM barang"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
    $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

    $data_barang = select("SELECT * FROM barang ORDER BY id_barang DESC LIMIT $awalData, $jumlahDataPerhalaman");
}
?>

<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0"><i class="fas fa-list-ul"></i> Dashboard Barang</h1>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Grafik 1 -->
            <div class="card mb-4">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white"><i class="fas fa-chart-line"></i> Total Jumlah Barang per Tanggal</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartLine" height="100"></canvas>
                </div>
            </div>

            <!-- Grafik 2 -->
            <div class="card mb-4">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white"><i class="fas fa-chart-bar"></i> Top 10 Barang Berdasarkan Jumlah</h3>
                </div>
                <div class="card-body">
                    <canvas id="chartBar" height="100"></canvas>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Data Barang</h3>
                </div>
                <div class="card-body">
                    <a href="tambah-barang.php" class="btn btn-primary btn-sm mb-2"><i class="fas fa-plus"></i> Tambah</a>
                    <button type="button" class="btn btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalFilter">
                        <i class="fas fa-search"></i> Filter Data
                    </button>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Barcode</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($data_barang as $barang): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $barang['nama']; ?></td>
                                    <td><?= $barang['jumlah']; ?></td>
                                    <td>Rp. <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= $barang['barcode']; ?>&print=true" />
                                    </td>
                                    <td><?= date("d/m/Y | H:i:s", strtotime($barang['tanggal'])); ?></td>
                                    <td class="text-center">
                                        <a href="ubah-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i> Ubah</a>
                                        <a href="hapus-barang.php?id_barang=<?= $barang['id_barang']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i> Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-2 justify-content-end d-flex">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php if ($halamanAktif > 1): ?>
                                    <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif - 1 ?>">&laquo;</a></li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $jumlahHalaman; $i++): ?>
                                    <li class="page-item <?= $i == $halamanAktif ? 'active' : '' ?>">
                                        <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($halamanAktif < $jumlahHalaman): ?>
                                    <li class="page-item"><a class="page-link" href="?halaman=<?= $halamanAktif + 1 ?>">&raquo;</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="modalFilter" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title"><i class="fas fa-search"></i> Filter Data</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="tgl_awal">Tanggal Awal</label>
                        <input type="date" name="tgl_awal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tgl_akhir">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success btn-sm" name="filter">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Line
    new Chart(document.getElementById('chartLine').getContext('2d'), {
        type: 'line',
        data: {
            labels: <?= json_encode($labels1); ?>,
            datasets: [{
                label: 'Total Jumlah Barang',
                data: <?= json_encode($data1); ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.4,
                fill: true
            }]
        }
    });

    // Grafik Bar
    new Chart(document.getElementById('chartBar').getContext('2d'), {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels2); ?>,
            datasets: [{
                label: 'Jumlah Barang',
                data: <?= json_encode($data2); ?>,
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    title: { display: true, text: 'Jumlah Barang' }
                },
                y: {
                    title: { display: true, text: 'Nama Barang' }
                }
            }
        }
    });
</script>
