<?php 
session_start();
if (!isset($_SESSION["level"])=="admin") {
	header("Location: ../login.php");
  exit;
  }
  require '../admin/functions.php';

// ambil data di URL 
$kode_pengeluaran = $_GET['kode_pengeluaran'];
//query data 
$transaksi_pengeluaran =tampil_data ("SELECT * FROM transaksi_pengeluaran JOIN akun ON akun.kode_akun = transaksi_pengeluaran.kode_akun WHERE kode_pengeluaran = '$kode_pengeluaran'") [0];	
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["ubah"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (ubah_transaksi_pengeluaran ($_POST) > 0) {
   echo "<script> 
       alert('Data Berhasil Diubah!');
       document.location.href='transaksi_pengeluaran.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Diubah!');
       document.location.href='transaksi_pengeluaran.php';
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
            <h1>Edit Transaksi Pengeluaran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi Pengeluaran</li>
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
                <h3 class="card-title">Edit Transaksi Pengeluaran</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post"  enctype="multipart/form-data">
                <div class="card-body">
                  <input type="hidden" name="kode_kas" value="<?= $transaksi_pengeluaran['kode_kas']; ?>">
                  <input type="hidden" name="kode_pengeluaran" value="<?= $transaksi_pengeluaran['kode_pengeluaran']; ?>">
                <div class="form-group">
                    <label for="penginput">Penginput</label>
                    <input type="text" name="kode_akun" value="<?= $transaksi_pengeluaran['nama']; ?>" class="form-control" readonly>
                  </div>
                  
                  <div class="form-group">
                    <label for="tgl_input">Tanggal Input</label>
                    <input type="date" name="tgl_input" value="<?= date($transaksi_pengeluaran['tgl_input'])  ; ?>" class="form-control"  >
                  </div>
                       
                  <div class="form-group">
                    <label for="jumlah_pengeluaran">Jumlah Pengeluaran</label>
                    <input type="text" name="jumlah_pengeluaran" value="<?= date($transaksi_pengeluaran['jumlah_pengeluaran'])  ; ?>" class="form-control"  >
                  </div>

                  <div class="form-group">
                    <label for="gambar">Bukti Nota</label> <br> 
                    <?php if ($transaksi_pengeluaran["bukti_nota"]=="") : ?>
                      <a  href="../../dist/img/no_image.jpg" data-toggle="lightbox"> 
                      <img src="../../dist/img/no_image.jpg" width=70;></a><br> <br>
                    <?php else :?>   
                        <?php  echo '<img  style="width: 100px;" src="data:image/jpeg;base64,'.base64_encode( $transaksi_pengeluaran['bukti_nota'] ).' "/>';  ?><br> <br>
                    <?php endif; ?> 
                    <input type="file" class="form-control-file" id="gambar" name="bukti">
                  </div> 

                
                  <div class="form-group">
                        <label for="keterangan">Keterangan</label><br>
                        <textarea name="keterangan" id="keterangn" name="keterangan" cols="60" rows="10"><?= $transaksi_pengeluaran['keterangan']; ?></textarea>
                  </div>     
                  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="ubah">ubah</button>
                  <a  href="kategori_kos.php" name="close" class="btn btn-secondary">Close</a>
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
