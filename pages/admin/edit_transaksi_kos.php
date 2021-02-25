<?php 
require 'functions.php';

// ambil data di URL 
$kode_t_kamar = $_GET['kode_t_kamar'];
//query data 
$daftar_kos =tampil_data ("SELECT * FROM transaksi_kos RIGHT JOIN kamar_kos ON transaksi_kos.kode_kamar = kamar_kos.kode_kamar LEFT JOIN pelanggan ON transaksi_kos.kode_pelanggan = pelanggan.kode_pelanggan LEFT JOIN akun ON pelanggan.kode_akun = akun.kode_akun JOIN kategori_kos ON kategori_kos.kode_kategori = kamar_kos.kode_kategori WHERE kode_t_kamar = '$kode_t_kamar'") [0];	
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["ubah"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (ubah_transaksi_kos ($_POST) > 0) {
   echo "<script> 
       alert('Data Berhasil Diubah!');
       document.location.href='transaksi_kos.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Diubah!');
       document.location.href='transaksi_kos.php';
     </script>";	
 } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | DataTables</title>

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
            <h1>Edit Transaksi Kos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi Kos</li>
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
                <h3 class="card-title">Edit Transaksi Kos</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post">
                <div class="card-body">
                <input type="hidden" name="kode_t_kamar" value="<?= $daftar_kos['kode_t_kamar']; ?>">
                  <div class="form-group">               
                    <label for="kategori_kos">kategori Kos</label>
                    <select name="kode_kategori" id="kategori_kos"   class="form-control" required="required">
                       <?php
                       $kategori_kos=tampil_data ("SELECT * FROM kategori_kos");	  
                       foreach ($kategori_kos as $data) :
                                if ($daftar_kos['kode_kategori']==$data['kode_kategori']) {
                                    $select="selected";
                                    }else{
                                    $select="";
                                    }
                                    ?>
                        <option value="<?= $data['kode_kategori'];?>"
                        <?= $select;?>><?= $data['kategori_kos'];?></option>
                        <?php  endforeach; ?>
                    </select>                  
                </div>
                <div class="form-group">               
              
              <label for="kode_kamar">Nomor Kamar</label>
              <select name="kode_kamar" id="kode_kamar" class="form-control" required="required">
           
                 <?php
                  $kode_kategori = $daftar_kos["kode_kategori"];  
                  $kode_kamar =tampil_data ("SELECT * FROM kamar_kos  INNER JOIN kategori_kos ON kategori_kos.kode_kategori = kamar_kos.kode_kategori ORDER BY kode_kamar");	 
                
                 foreach ($kode_kamar as $data) :
                          if ($daftar_kos['kode_kamar']==$data['kode_kamar']) {
                              $select="selected";
                              }else{
                              $select="";
                              }
                              ?>
                  <option  id="kode_kamar" class="<?php echo $data['kode_kategori']; ?>"value="<?= $data['kode_kamar'];?>"
                  <?= $select;?>><?= $data['kode_kamar'];?></option>
                  <?php  endforeach; ?>
              </select>                  
          </div>  
                <div class="form-group">               
                    <label for="kategori_kos">Pelanggan</label>
                    <select name="kode_pelanggan"   class="form-control" required="required">
                       <?php
                       $pelanggan=tampil_data ("SELECT * FROM pelanggan INNER JOIN akun ON akun.kode_akun = pelanggan.kode_akun");	  
                       foreach ($pelanggan as $data) :
                                if ($daftar_kos['kode_pelanggan']==$data['kode_pelanggan']) {
                                    $select="selected";
                                    }else{
                                    $select="";
                                    }
                                    ?>
                        <option value="<?= $data['kode_pelanggan'];?>"
                        <?= $select;?>><?= $data['nama'];?></option>
                        <?php  endforeach; ?>
                    </select>                  
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

 <!-- Chained Jquery -->
 <script src="../../dist/js/jquery-chained.min.js"></script>

 <script>
            $(document).ready(function() {
                $("#kode_kamar").chained("#kategori_kos");
                              
            });
  </script>

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
