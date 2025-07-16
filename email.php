<?php

session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
           alert('login dulu');
           document.location.href = 'login.php';
           </script>";
    exit;
}

$title = 'Kirim Email';

include 'layout/header.php';


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-envelope"></i> Kirim Email</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Kirim Email</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <hr>
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email penerima" class="form-label">Email Penerima</label>
                    <input type="text" class="form-control" id="email penerima" name="email penerima" placeholder="Email Penerima..."
                        required>
                </div>
                <div class="mb-3">
                    <label for="subject" class="form label">Subject</label>
                    <input type="number" class="form-control" id="subject" name="subject"
                        placeholder="Subject..." required>
                </div>
                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea name="pesan" id="pesan" cols="30" rows="10" class="form-control"></textarea>
                </div>
               <button type="submit" name="tambah" class="btn btn-primary" style="float: right;">Kirim</button>
            </form>
        </div>
</div>
<?php include 'layout/footer.php'; ?>