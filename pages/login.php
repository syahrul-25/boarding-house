<?php 
session_start();
require 'admin/functions.php';

// cek cookie 
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
	$id = $_COOKIE['id'];
  $key = $_COOKIE['key'];
  
 
	// ambil username berdasarkan id 
	$result = mysqli_query($conn, "SELECT email from akun WHERE kode_akun = $id");
	$row = mysqli_fetch_assoc($result);


	// cek cookie dan username 
	if ($key === hash('sha256', $row['email'])) {
		 $_SESSION['login'] = true;
	}
	
}

// cek apakah tombol submit sudah ditekan atau belum 
if (isset($_POST['login'])) {
	$email =$_POST['email'];
  $password =$_POST['password']; 
  $result1 = "SELECT * FROM akun LEFT JOIN pelanggan  ON pelanggan.kode_akun = akun.kode_akun  WHERE email ='$email'";
  $akun =mysqli_query($conn,$result1);
  
 
	if (mysqli_num_rows($akun) )  {	 
		// cek password 
    $row = mysqli_fetch_assoc($akun);
     if (password_verify($password, $row['password'])) {
	    // set session 
      $_SESSION['kode_akun']   = $row['kode_akun'];
      $_SESSION['email']   = $row['email'];
      $_SESSION['nama']   = $row['nama'];
      $_SESSION['password']   = $row['password'];
      $_SESSION['level']   = $row['level'];
      $_SESSION['status']   = $row['status'];
      $_SESSION['kode_pelanggan']   = $row['kode_pelanggan'];
      $_SESSION["login"]= true;

        // check level 
        if ($_SESSION['level']=='superadmin') {
          header("Location: admin/index.php");
          exit;
        } else if ($_SESSION['level']=='admin') {
          header("Location: subadmin/index.php");
          exit;
        }
      else if ($_SESSION['level']=='pelanggan' and $_SESSION['status']==1) {
          header("Location: pelanggan/index.php");
          exit;
        }
		}	
    

  }
  $error = true;
 
  
}

 
 ?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Rumah Sewaku</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <style>

#remember {
  margin-left:-18px;
  color: red;
}
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index2.html"><b>Rumah</b>Sewaku
    <img src="../dist/img/home.png" alt="AdminLTE Logo" class="brand-image"  width="30" style="margin-bottom: 10px;"></a>
     
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login untuk memulai sesi</p>
      
                <div class="text-center">
                  <?php if (isset($error)) : ?>
                  <p id="remember" >Username Atau Password Salah !!</p>
                  <?php endif; ?>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="login">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <br>
      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="pelanggan/tambah_akun_pelanggan.php" class="text-center">Registrasi Pelanggan Baru</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
