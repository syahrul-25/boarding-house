<?php 
session_start(); 
require 'functions.php';
if (!isset($_SESSION["level"])=="superadmin") {
	header("Location: ../login.php");
  exit;
  }
$setoran= tampil_data("SELECT * FROM setoran_owner JOIN akun ON akun.kode_akun = setoran_owner.kode_akun ORDER BY tgl_store ");
// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (tambah_setoran($_POST) > 0) {
 
 
   echo "<script> 
       alert('Data Berhasil Ditambahkan!');
       document.location.href='setoran.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Ditambahkan!');
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
<?php
  // kode kas
  $id = id("SELECT max(kode_kas) as kodeTerbesar FROM kas");
  $kodeKas = $id['kodeTerbesar'];
  // mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
  $urutan = (int) substr($kodeKas, 3, 3);
  $urutan++;
  $huruf = "kas";
  $kodeKas = $huruf . sprintf("%03s", $urutan);
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
            <h1>Setoran</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Setoran</li>
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
                <h3 class="card-title">Data Setoran</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
            <div class="card-header  ">               
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                 Tambah Data Setoran
                </button>
                 <div class="modal fade" id="modal-default">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Form Tambah data Setoran</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                   
              <!-- form start -->
              <form action="" enctype="multipart/form-data" method="post">
                <div class="card-body">
                  <input type="hidden" name="kode_kas" value="<?= $kodeKas; ?>">
                  <div class="form-group">
                  <label for="sumber">Penginput</label>
                      <select name="nama" id="kode_akun" class="form-control" disabled>
                        <?php
                         $nama = $_SESSION['nama'];
                         $akun = tampil_data("SELECT akun.kode_akun FROM akun WHERE nama = '$nama'")[0];
                        ?>
                          <option value=""><?= $nama; ?> </option>
                      </select>
                      <input type="hidden" name="kode_akun" value="<?= $akun['kode_akun'] ?>">
                      </div>  

                      <div class="form-group">
                        <label for="tgl_input">Tanggal Setor</label>
                        <input type="date" class="form-control" name="tgl_store" >
                        <input type="hidden" class="form-control" name="tgl_input" value="<?= date('Y-m-d') ?>" required>
                     </div>

                      <div class="form-group">
                        <label for="jumlah_setoran">Jumlah Setoran</label>
                         <input type="text" class="form-control" name="jumlah_setoran" required  autocomplete="off">
                     </div>
                     
                     <div class="form-group">
                        <label for="bukti">Bukti Setoran</label>
                        <input type="file" class="form-control-file" name="bukti">
                     </div>
                     
                     <div class="form-group">
                        <label for="keterangan">Keterangan</label><br>
                        <textarea name="keterangan" id="keterangn" name="keterangan" cols="60" rows="10"></textarea>
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
                <!-- /.modal -->
              </div>
             
              <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Penginput</th>
                    <th>Tanggal Setor</th>
                    <th>Jumlah Setoran</th>
                    <th>Keterangan</th>
                    <th>Bukti Setoran</th>
                    <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=1; ?>
                  <?php foreach($setoran as $data) : ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td> <?= $data['nama']; ?></td>
                    <td> <?=  tgl_indo($data['tgl_store']); ?></td>
                    <td> <?= "Rp.".number_format($data['jumlah_store']).",-"; ?></td>
                    <?php if ($data['keterangan']=='') : ?>
                    <td>-</td>
                    <?php  else: ?>
                    <td> <?= $data['keterangan']; ?></td>
                    <?php endif; ?>
                    <td> <a class="btn btn-primary " href="#" data-placement="top" title="Bukti Pengeluaran" data-toggle="modal" data-target="#modal-lg_bukti<?php echo $data['kode_setoran']; ?>"> <i class="fa fa-info-circle" aria-hidden="true"></i></a>
                              <!-- modal Bukti -->
                              <div class="modal fade" id="modal-lg_bukti<?php echo $data['kode_setoran']; ?>">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Bukti Setoran</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <hr>
                                    <?php if ($data["bukti_store"] == "") : ?>
                                      <div style="text-align: center;">
                                        <img src="../../dist/img/no_image.jpg" style="width: 400px;" class="img-fluid mb-2" alt="">
                                      </div>
                                    <?php else : ?>
                                      <div style="text-align: center;">
                                        <?php
                                        echo '<img  style="width: 400px;" src="data:image/jpeg;base64,' . base64_encode($data['bukti_store']) . ' "/>';  ?>
                                      </div>
                                    <?php endif; ?>
                                  </div>
                                </div>
                              </div>
                              <!-- end modal Bukti-->
                            </td>
                    <td>
                      <a class="fas fa-edit btn btn-success " href="edit_setoran.php?kode_setoran=<?php echo $data['kode_setoran']; ?>" data-toggle="tooltip" data-placement="top" ></a>
                      <a onclick="return confirm('Yakin ingin menghapus data ini')" href="hapus_setoran.php?kode_kas=<?php echo $data['kode_kas']; ?>" class="fas fa-trash-alt btn btn-danger"></a>
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
