<?php 
session_start(); 
require '../admin/functions.php';

// tangkap kode akun 
// Check kode akun yang baru inputkan 
$kode_akun =id("SELECT max(kode_akun) AS kodeAkun FROM akun");
$kode_akunn = $kode_akun['kodeAkun'];

//data akun 
$akun = tampil_data("SELECT akun.nama FROM akun WHERE kode_akun = '$kode_akunn'")[0]['nama'];
 

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (tambah_pelanggan ($_POST) > 0) {
 
 
   echo "<script> 
       alert('Data Berhasil Ditambahkan, Tunggu Data di Validasi Oleh Admin dan silahkan Login !');
       document.location.href='../login.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Ditambahkan!');
       document.location.href='tambah_data_pelanggan.php';
     </script>";	
 } 
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
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<?php 
// kode akun 
$id = id ("SELECT max(kode_pelanggan) as kodeTerbesar FROM pelanggan"); 
$kodePelanggan = $id['kodeTerbesar'];
// mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
$urutan = (int) substr($kodePelanggan, 3, 3);
$urutan++;
$huruf = "P";
$kodePelanggan= $huruf . sprintf("%03s", $urutan); 
?>


<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Rumah</b>Sewaku</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Lengkapi Data Diri <?= $akun; ?></p>

      <form action="" method="post" enctype="multipart/form-data">
      <!-- hidden input -->
      <input type="hidden" name="kode_akun" value="<?= $kode_akunn; ?>">
      <input type="hidden" name="kode_pelanggan" value="<?= $kodePelanggan; ?>">
      <!-- hidden input -->
      
        <div class="input-group mb-3">
          <input type="text" name="no_hp" class="form-control" placeholder="Nomor Hp/telephone">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
                  <select class="form-control select2" style="width: 100%;" name="jk">
                    <option selected="selected">Jenis Kelamin</option>
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="Perempuan">Perempuan</option>
                  </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="foto_diri">
                        <label class="custom-file-label" for="exampleInputFile">Foto Diri</label>
                      </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="ktp">
                        <label class="custom-file-label" for="exampleInputFile">KTP</label>
                      </div>
                      </div>
                  </div>
      
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
           
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit"  name="submit" class="btn btn-primary btn-block">Simpan </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
</body>
</html>
