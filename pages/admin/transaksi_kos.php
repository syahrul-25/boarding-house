<?php
session_start(); 
require 'functions.php';
if (!isset($_SESSION["level"])=="superadmin") {
	header("Location: ../login.php");
  exit;
  }
$daftar_kos=tampil_data ("SELECT * FROM transaksi_kos RIGHT JOIN kamar_kos ON transaksi_kos.kode_kamar = kamar_kos.kode_kamar LEFT JOIN pelanggan ON transaksi_kos.kode_pelanggan = pelanggan.kode_pelanggan LEFT JOIN akun ON pelanggan.kode_akun = akun.kode_akun JOIN kategori_kos ON kategori_kos.kode_kategori = kamar_kos.kode_kategori");
 
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (tambah_transaksi_kos ($_POST) > 0) {
 
 
   echo "<script> 
       alert('Data Berhasil Ditambahkan!');
       document.location.href='transaksi_kos.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Ditambahkan!');
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
            <h1>Transaksi Kamar Kos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Transaksi Kamar Kos</li>
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
                <h3 class="card-title">Data Transaksi Kamar Kos</h3>
              </div>
             
             
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kategori Kos</th>
                    <th>Nomor Kamar</th>
                    <th>Nama Pelanggan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=1; ?>
                  <?php foreach($daftar_kos as $data) : ?>
                  <tr>
                  <?php if($data['nama'] == null) : ?>
                    <td><?= $i; ?></td>
                    <td><?= $data['kategori_kos'] ?></td>
                    <td> <?= $data['kode_kamar']; ?></td>
                    <td style="color:red;"> Masih Kosong </td>
                    <td style="color:red;">
                      Masih Kosong
                    </td>
                    <td> 
                    <?php $kode =  $data['kode_kamar']; ?>
                    <a class="fas fa-checklist btn btn-primary" href="tambah_transaksi_kamar.php?kode_kamar=<?= $kode; ?>" data-toggle="tooltip" data-placement="top"    ><i class="fa fa-plus" aria-hidden="true">
                    </i></a>
                    </td>
                    <?php else: ?>
                    <td><?= $i; ?></td>
                    <td><?= $data['kategori_kos'] ?></td>
                    <td><?= $data['kode_kamar']; ?></td>
                    <td>
                      <?= $data['nama']; ?>
                    </td>
                    <td style="color:green;">
                      Sudah Di isi
                    </td>
                    <td>
                      <a class="fas fa-edit btn btn-success " href="edit_transaksi_kos.php?kode_t_kamar=<?php echo $data['kode_t_kamar']; ?>" data-toggle="tooltip" data-placement="top" ></a>
                      <a onclick="return confirm('Yakin ingin menghapus data ini')" href="hapus_transaksi_kos.php?kode_t_kamar=<?php echo $data['kode_t_kamar']; ?>" class="fas fa-trash-alt btn btn-danger"></a>
                      </td>
                    <?php endif; ?>
                  </tr>
                  <?php $i++ ?>
                  <?php endforeach; ?>
                  </tbody>
                
                </table>
              </div>
              <div class="modal fade" id="modal-default<?= $kode;?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Form Tambah Data Transaksi Kos</h4>
                        <input type="text" value="<?= $kode;?>">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                   
              <!-- form start -->
              <form action="" method="post">
                <div class="card-body">
           
                  <div class="form-group">
                    <label for="sumber">Kategori Kos</label>
                    <input type="text" class="form-control" value="<?= $data['kategori_kos']; ?>" readonly>
                  
                  </div> 
                  <div class="form-group">               
                    <label for="kode_kamar">Nomor Kamar</label>
                    <input type="text" class="form-control" name="kode_kamar" value="<?= $data['kode_kamar']; ?>" readonly>           
                </div>
                <div class="form-group">             
                    <label for="sumber">Nama Pelanggan</label>
                    <select name="kode_pelanggan" id="kode_akun" class="form-control" required="required" onchange="changeValue(this.value)">
                      <option value="">Pilih Nama Pelanggan</option> 
                      <?php $akun=tampil_data("SELECT * FROM pelanggan INNER JOIN akun ON akun.kode_akun = pelanggan.kode_akun"); 
                      foreach ($akun as $row) : ?>
                      <option value="<?php echo $row['kode_pelanggan']; ?>">
                           <?php echo $row['nama']; ?>
                      </option>     
                      <?php endforeach; ?>
                                     
                    </select>  
                  </div>
                   
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
                       
               </div>
                     
                     
                   
                  </div>
                  <!-- /.modal-dialog -->
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

 <!-- Chained Jquery -->
 <script src="../../dist/js/jquery-chained.min.js"></script>

 <script>
            $(document).ready(function() {
                $("#kode_kamar").chained("#kategori_kos");
                              
            });
  </script>

<script>
            $(document).ready(function() {
                $("#kode_pelanggan").chained("#kode_akun");
                              
            });
  </script>
<script type="text/javascript">    
    <?php echo $jsArray; ?>  
  
    function changeValue(x){  
    document.getElementById('kode_pelanggan').value = prdName[x].kode_pelanggan;
    
    };  
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
