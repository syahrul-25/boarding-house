<?php 
require 'functions.php';
$pelanggan=tampil_data ("SELECT * FROM pelanggan Join akun ON pelanggan.kode_akun = akun.kode_akun 
                          WHERE statuss = 1 Order By nama ASC");	
                          
 
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (tambah_kategori_kos ($_POST) > 0) {
 
 
   echo "<script> 
       alert('Data Berhasil Ditambahkan!');
       document.location.href='kategori_kos.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Ditambahkan!');
       document.location.href='kategori_kos.php';
     </script>";	
 } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rumah Sewaku</title>

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
            <h1>Pelanggan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pelanggan</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
          
            </div>
            <!-- /.card -->
              <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data pelanggan</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
          
             
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead style="text-align: center;">
              
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>No Hp</th>
                    <th>Status</th>
                    <th >Tanggal Daftar</th>
                    <th>Foto Diri</th>
                    <th>KTP</th>                   
                   </tr>
                  </thead>
                  <tbody>
                  <?php $i=1; ?>
                  <?php foreach($pelanggan as $data) : ?>
                  <tr style="text-align: center;">
                    <td><?= $i; ?></td>
                    <td> <?= $data['nama']; ?></td>
                    <td> <?= $data['jk']; ?></td>
                    <td> <?= $data['no_hp']; ?></td>
                
                    <?php $status = $data['statuss'];
                          $status="aktif";?>
                    <td> <?= $status; ?></td>
                    <td> <?= tgl_indo($data["tgl_daftar"]);?></td>
                    <td>                     
                      <a class="btn btn-primary " href="#"   data-placement="top" title="Foto Diri" data-toggle="modal" data-target="#modal-lg_foto<?php echo $data['kode_pelanggan']; ?>"> <i class="fa fa-info-circle" aria-hidden="true"></i></a>
                       <!-- modal keterangan -->          
                       <div class="modal fade" id="modal-lg_foto<?php echo $data['kode_pelanggan']; ?>">
                      <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                      <div class="modal-header">                
                      <h4 class="modal-title"><?php echo $data['nama']; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <hr>
                        <?php if ($data["foto_diri"]=="") : ?>
                        <div style="text-align: center;">
                        <img src="img/no_image.jpg"  style="width: 400px;"  class="img-fluid mb-2"alt="">
                        </div>
                        <?php else :?> 
                        <div style="text-align: center;" >
                        <?php  
                         echo '<img  style="width: 400px;" src="data:image/jpeg;base64,'.base64_encode( $data['foto_diri'] ).' "/>';  ?>
                        </div>
                        <?php endif; ?> 
                        </div>
                        </div>
                        </div>
                       <!-- end modal keterangan -->
                    </td>

                    <td>                     
                      <a class="btn btn-primary " href="#"   data-placement="top" title="KTP" data-toggle="modal" data-target="#modal-lg_ktp<?php echo $data['kode_pelanggan']; ?>"> <i class="fa fa-info-circle" aria-hidden="true"></i></a>
                       <!-- modal keterangan -->          
                       <div class="modal fade" id="modal-lg_ktp<?php echo $data['kode_pelanggan']; ?>">
                      <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                      <div class="modal-header">                
                      <h4 class="modal-title"><?php echo $data['nama']; ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <hr>
                        <?php if ($data["ktp"]=="") : ?>
                        <div style="text-align: center;">
                        <img src="img/no_image.jpg"  style="width: 400px;"  class="img-fluid mb-2"alt="">
                        </div>
                        <?php else :?> 
                        <div style="text-align: center;">
                        <?php  
                         echo '<img  style="width: 400px;" src="data:image/jpeg;base64,'.base64_encode( $data['ktp'] ).'"/>'; ?>
                           
                        </div>
                        <?php endif; ?> 
                        </div>
                        </div>
                        </div>
                       <!-- end modal keterangan -->
                    </td>   
                    </tr>
                  <?php $i++ ?>
                  <?php endforeach; ?>
                  </tbody>
                   
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
  
  <!-- Filterizr-->
  <script src="../../vendor/filterizr/jquery.filterizr.min.js"></script>
  <!-- Ekko Lightbox -->
  <script src=".../../vendor/ekko-lightbox/ekko-lightbox.min.js"></script> 

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
