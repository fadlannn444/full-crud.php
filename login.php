<?php

session_start();

include 'config/app.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $secret_key = "6LfrLoMrAAAAAGULZ33Ft0eoXeHTGI9Ry780CSAi";

    $verifikasi = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' .
        $_POST['g-recaptcha-response']);

    $response = json_decode($verifikasi);

    $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

    if (mysqli_num_rows($result) == 1) {
        $hasil = mysqli_fetch_assoc($result);

        if (password_verify($password, $hasil['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['id_akun'] = $hasil['id_akun'];
            $_SESSION['nama'] = $hasil['nama'];
            $_SESSION['username'] = $hasil['username'];
            $_SESSION['email'] = $hasil['email'];
            $_SESSION['level'] = $hasil['level'];

            header("Location: index.php");
            exit;
        } else {
            $error = true;
        }
    } else {
        $erorRecaptcha = true;
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Signin Template · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


    <!-- Favicons -->
    <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <img class="mb-4" src="assets/img/bootstrap-logo.svg" alt="" width="72" height="57">
        <h1 class="h3 mb-3 fw-normal">Admin Login</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center">
                <b>Username/Password SALAH</b>
            </div>
        <?php endif; ?>

        <?php if(isset($error)) : ?>
            <div class="alert alert-danger text-center">
                <b>Recaptcha Tidak Valid</b>
            </div>
            <?php endif; ?>

        <form action="" method="POST">
            <div class="input-group mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username..." required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password..." required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6LfrLoMrAAAAACsdS-2m-QePU_fvVUSn7-3Zwaa9"></div>
            </div>

            <div class="row">
                <div class="col-8">
                </div>

                <div class="col-4">
                    <button type="submit" name="login" class="btn btn-primary btn-block">Masuk</button>
                </div>
            </div>
        </form>

        <hr>
        <p class="mb-1 text-center">
            <span class="mt-5 mb-3 text-muted">Developer &copy;
                <a href="https://mubatekno.com">Muba Teknologi</a> <?= date('Y') ?>
            </span>
        </p>
    </main>

    <script src="assets-template/plugins/jquery/jquery.min.js"></script>
    <script src="assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets-template/dist/js/adminlte.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>