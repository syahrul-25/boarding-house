<?php
session_start(); 
if (!isset($_SESSION["level"])=="superadmin") {
	header("Location: ../login.php");
  exit;
  }
require 'functions.php';
$tahun = date('Y');
// ambil data di URL 
$kode_t_kamar = $_GET['kode_t_kamar'];

$transaksi_bulan = tampil_data("SELECT
                                `akun`.`nama`,
                                `transaksi_kos`.`kode_kamar`,
                                `transaksi_bulan_dibayar`.`tahun`,
                                `transaksi_bulan_dibayar`.`kode_t_bulan`,
                                `transaksi_bulan_dibayar`.`bulan`,
                                `transaksi_bulan_dibayar`.`jumlah`,
                                `transaksi_bulan_dibayar`.`status`,
                                `transaksi_bulan_dibayar`.`keterangan`
                              FROM
                                `transaksi_kos`
                                INNER JOIN `transaksi_pembayaran` ON `transaksi_kos`.`kode_t_kamar` =
                              `transaksi_pembayaran`.`kode_t_kamar`
                                INNER JOIN `transaksi_bulan_dibayar` ON `transaksi_pembayaran`.`kode_bayar` =
                              `transaksi_bulan_dibayar`.`kode_bayar`
                                INNER JOIN `pelanggan` ON `transaksi_kos`.`kode_pelanggan` =
                              `pelanggan`.`kode_pelanggan`
                                INNER JOIN `akun` ON `pelanggan`.`kode_akun` = `akun`.`kode_akun`
                                WHERE `transaksi_kos`.`kode_t_kamar` = $kode_t_kamar");

$result = $conn->query("SELECT
                                `transaksi_bulan_dibayar`.`kode_t_bulan`
                              FROM
                                `transaksi_kos`
                                INNER JOIN `transaksi_pembayaran` ON `transaksi_kos`.`kode_t_kamar` =
                              `transaksi_pembayaran`.`kode_t_kamar`
                                INNER JOIN `transaksi_bulan_dibayar` ON `transaksi_pembayaran`.`kode_bayar` =
                              `transaksi_bulan_dibayar`.`kode_bayar`
                              WHERE `transaksi_bulan_dibayar`.`bulan` IN(
                              SELECT `transaksi_bulan_dibayar`.`bulan`
                              FROM `transaksi_bulan_dibayar`
                              GROUP BY `transaksi_bulan_dibayar`.`bulan`
                              having count(bulan) > 1 and status='belum lunas' and `transaksi_bulan_dibayar` . `tahun` = $tahun and `transaksi_kos`.`kode_t_kamar` = $kode_t_kamar
                              )");

 

$bulan_belum_lunas = [];
while ($row = $result->fetch_assoc()) {
  $bulan_belum_lunas[] = $row['kode_t_bulan'];
}


// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
  if (tambah_transaksi_bulan_dibayar($_POST) > 0) {


    echo "<script> 
       alert('Data Berhasil Ditambahkan!');
       document.location.href='transaksi_bulan_dibayar.php?kode_bayar=$kode_bayar';
     </script>";
  } else {
    echo "<script> 
       alert('Data Gagal Ditambahkan!');
       document.location.href='transaksi_bulan_dibayar.php?kode_bayar=$kode_bayar';
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
    <?php include "navbar.php"; ?>
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
              <h1>Transaksi Bulan Dibayar</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Bulan Dibayar</li>
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
                  <h3 class="card-title">Data Transaksi Bulan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Penghuni</th>
                          <th>Kode Kamar</th>
                          <th>Tahun</th>
                          <th>Bulan</th>
                          <th>Jumlah Bayar</th>
                          <th>Status</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($transaksi_bulan as $data) : ?>
                          <?php if (in_array($data['kode_t_bulan'], $bulan_belum_lunas)) : ?>
                            <?php continue; ?>
                          <?php endif; ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td><?= $data['nama']; ?></td>
                            <td><?= $data['kode_kamar']; ?></td>
                            <td> <?= $data['tahun']; ?></td>
                            <td> <?= bulan_indo(date($data['bulan'])); ?></td>
                            <td><?= "Rp.".number_format($data['jumlah']).",-"; ?></td>
                            <?php if ($data['status']=='belum lunas' ) : ?>
                              <td style="color: red; font-weight: bold;"> BELUM LUNAS</td>
                              <td style="color: red; font-weight: bold;"> <?= $data['keterangan']; ?></td>
                            <?php  else: ?>  
                              <td style="color: green; font-weight: bold;"> LUNAS</td>
                              <td style="color: green; font-weight: bold;"> Sudah Lunas</td>
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
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
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