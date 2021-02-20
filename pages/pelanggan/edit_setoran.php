<?php 
session_start();
if (!isset($_SESSION["level"])=="superadmin") {
	header("Location: ../login.php");
  exit;
  }
  require '../admin/functions.php';

// ambil data di URL 
$kode_setoran = $_GET['kode_setoran'];
//query data 
$setoran=tampil_data ("SELECT * FROM setoran_owner JOIN akun ON akun.kode_akun = setoran_owner.kode_akun WHERE kode_setoran = '$kode_setoran'") [0];	
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["ubah"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (ubah_setoran ($_POST) > 0) {
   echo "<script> 
       alert('Data Berhasil Diubah!');
       document.location.href='setoran.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Diubah!');
       document.location.href='setoran.php';
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
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

   <!-- navbar -->
   <?php  include "navbar.php"; ?>
  <!-- endnavbar -->
  

    
  <!-- sidebar -->
  <?php include 'sidebar.php'; ?>
  <!-- endsidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Setoran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Setoran</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Setoran</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post"  enctype="multipart/form-data">
                <div class="card-body">
                  <input type="hidden" name="kode_kas" value="<?= $setoran['kode_kas']; ?>">
                  <input type="hidden" name="kode_setoran" value="<?= $setoran['kode_setoran']; ?>">
                <div class="form-group">
                    <label for="penginput">Penginput</label>
                    <input type="text" name="kode_akun" value="<?= $setoran['nama']; ?>" class="form-control" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label for="tgl_store">Tanggal Store</label>
                    <input type="date" name="tgl_store" value="<?= date($setoran['tgl_store'])  ; ?>" class="form-control"  >
                  </div>
                       
                  <div class="form-group">
                    <label for="jumlah_setoran">Jumlah Setoran</label>
                    <input type="text" name="jumlah_setoran" value="<?= date($setoran['jumlah_store'])  ; ?>" class="form-control"  >
                  </div>

                  <div class="form-group">
                    <label for="gambar">Bukti Store</label> <br> 
                    <?php if ($setoran["bukti_store"]=="") : ?>
                      <a  href="../../dist/img/no_image.jpg" data-toggle="lightbox"> 
                      <img src="../../dist/img/no_image.jpg" width=70;></a><br> <br>
                    <?php else :?>   
                        <?php  echo '<img  style="width: 100px;" src="data:image/jpeg;base64,'.base64_encode( $setoran['bukti_store'] ).' "/>';  ?><br> <br>
                    <?php endif; ?> 
                    <input type="file" class="form-control-file" id="gambar" name="bukti">
                  </div> 

                
                  <div class="form-group">
                        <label for="keterangan">Keterangan</label><br>
                        <textarea name="keterangan" id="keterangn" name="keterangan" cols="60" rows="10"><?= $setoran['keterangan']; ?></textarea>
                  </div>     
                  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="ubah">ubah</button>
                  <a  href="setoran.php" name="close" class="btn btn-secondary">Close</a>
                </div>
              </form>
            </div>
            </div>
            <!-- /.card -->
            </section>
            
    <!-- /.content -->
  </div>
  <!-- footer -->
  <?php include "footer.php" ?>
  <!-- endfooter -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
 <!-- Page level plugins -->
 <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../../dist/js/demo/datatables-demo.js"></script>

</body>
</html>
