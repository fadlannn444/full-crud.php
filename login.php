<?php


session_start();

include 'config/app.php';

//check apakah tombol login di tekan
if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  //check username
  $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

  //jika ada usernya
  if (mysqli_num_rows($result) == 1) {
    //check password nya
    $hasil = mysqli_fetch_assoc($result);

    if (password_verify($password, $hasil['password'])) {

      //set session
      $_SESSION['login'] = true;
      $_SESSION['id_akun'] = $hasil['id_akun'];
      $_SESSION['nama'] = $hasil['nama'];
      $_SESSION['username'] = $hasil['username'];
      $_SESSION['email'] = $hasil['email'];
      $_SESSION['level'] = $hasil['level'];

      //jika benar arahkan ke index.php
      header("Location: index.php");
      exit;

    }
  }
  //jika tidak ada user nya/login salah
  $error = true;

}


?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login</title>

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="assets/css/signin.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
</head>

<body class="text-center">

  <main class="form-signin">
    <form action="" method="POST">
      <img class="mb-4" src="assets/img/bootstrap-logo.svg" alt="Logo" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Admin Login</h1>

      <?php if(isset($error)) : ?>
      <div class="alert alert-danger text-center">
        <b>Username/Password Salah</b>

      </div>
      <?php endif; ?>

      <div class="form-floating mb-3">
        <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username..." required>
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password"
          required>
        <label for="floatingPassword">Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">Login</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
    </form>
  </main>

</body>

</html>