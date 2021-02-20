<?php
session_start(); 
if (!isset($_SESSION["level"])=="admin") {
	header("Location: ../login.php");
  exit;
  }
  require '../admin/functions.php';
 
$kode_akun = $_SESSION['kode_akun'];
 
$akun=tampil_data ("SELECT * FROM akun Where kode_akun = '$kode_akun' ");	
 
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {
  // cek apakah berhasil di tambahkan atau tidak
 if (registrasi ($_POST) > 0) {
 
   echo "<script> 
       alert('Data Berhasil Ditambahkan!');
       document.location.href='akun.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Ditambahkan!');
       document.location.href='akun.php';
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
  <style>
    tr {
      text-align: center;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<?php 
// kode akun 
$id = id ("SELECT max(kode_akun) as kodeTerbesar FROM akun"); 
$kodeAkun = $id['kodeTerbesar'];
// mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
$urutan = (int) substr($kodeAkun, 3, 3);
$urutan++;
$huruf = "kd";
$kodeAkun = $huruf . sprintf("%03s", $urutan); 
?>

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
            <h1>Akun Pengguna</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Akun Pengguna</li>
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
                <h3 class="card-title">Data Akun Pengguna</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                  <tr >
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=1; ?>
                  <?php foreach($akun as $data) : ?>
                  <tr>
                    <td> <?= $data['nama']; ?></td>
                    <td> <?= $data['email']; ?></td>
                  <?php if ($data['level']=='superadmin') : ?>
                     <td>Pengelola</td>
                   <?php else: ?>
                    <td> <?= $data['level']; ?></td>
                   <?php endif; ?> 
                    <?php if ($data['status']==1) : ?>
                    <td>
                      <a class="fas fa-edit btn btn-success " href="edit_akun.php?kode_akun=<?php echo $data['kode_akun']; ?>" data-toggle="tooltip" data-placement="top" ></a>
                      <a class=" btn btn-primary " href="ganti_pass.php?kode_akun=<?php echo $data['kode_akun']; ?>" data-toggle="tooltip" data-placement="top" ><i class="fa fa-lock"  ></i></a>
                   
                      </td>
                    <?php else: ?>
                    <td> <a class="fas fa-checklist btn btn-danger "type="button" href="validasi_akun.php?kode_akun=<?php echo $data['kode_akun']; ?>" data-toggle="tooltip" data-placement="top"  name="valid">Validasi</a> </td>
                    <?php endif; ?>
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
  <script type="text/javascript">    
    <?php echo $jsArray; ?>  
  
    function changeValue(x){  
    document.getElementById('kategori_kos').value = prdName[x].kategori_kos;

    };  
    </script> 
</body>
</html>
