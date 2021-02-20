<?php
session_start(); 
require '../admin/functions.php';
if (!isset($_SESSION["level"])=="pelanggan") {
	header("Location: ../login.php");
  exit;
  }

$kode_pelanggan = $_SESSION['kode_pelanggan'];
 
$transaksi_bayar = tampil_data("SELECT * FROM transaksi_pembayaran JOIN akun ON akun.kode_akun = transaksi_pembayaran.kode_akun JOIN transaksi_kos ON transaksi_kos.kode_t_kamar = transaksi_pembayaran.kode_t_kamar JOIN kamar_kos ON kamar_kos.kode_kamar = transaksi_kos.kode_kamar JOIN kategori_kos ON kategori_kos.kode_kategori = kamar_kos.kode_kategori  WHERE kode_pelanggan = '$kode_pelanggan' ORDER BY tgl_bayar ");



// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
  if (tambah_transaksi_pembayaran($_POST) > 0) {


    echo "<script> 
       alert('Data Berhasil Ditambahkan!');
       document.location.href='transaksi_pembayaran.php';
     </script>";
  } else {
    echo "<script> 
       alert('Data Gagal Ditambahkan!');
       document.location.href='transaksi_pembayaran.php';
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
  // kode akun 
  $id = id("SELECT max(kode_bayar) as kodeTerbesar FROM transaksi_pembayaran");
  $kodeBayar = $id['kodeTerbesar'];
  // mengambil angka dari kode barang terbesar, menggunakan fungsi substr dan diubah ke integer dengan (int)
  $urutan = (int) substr($kodeBayar, 3, 3);
  $urutan++;
  $huruf = "B";
  $kodeBayar = $huruf . sprintf("%03s", $urutan);
  ?>

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
              <h1>Riwayat Pembayaran Kos <?= $_SESSION['nama']; ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Transaksi Pembayaran</li>
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
             

                  <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th width=1;>No</th>
                          <th>Kategori Kos</th>
                          <th>Nomor Kamar</th>
                          <th>Tanggal Bayar</th>
                          <th>Metode</th>
                          <th>Bukti Bayar</th>
                          <th>Jumlah</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($transaksi_bayar as $data) : ?>
                          <tr>
                            <td><?= $i; ?></td>
                            <td> <?= $data['kategori_kos']; ?></td>
                            <td> <?= $data['kode_kamar']; ?></td>
                            <td> <?= tgl_indo($data["tgl_bayar"]); ?></td>
                            <td> <?= $data['metode_bayar']; ?></td>
                            <td> <a class="btn btn-primary " href="#" data-placement="top" title="Bukti Pembayaran" data-toggle="modal" data-target="#modal-lg_bukti<?php echo $data['kode_bayar']; ?>"> <i class="fa fa-info-circle" aria-hidden="true"></i></a>
                              <!-- modal keterangan -->
                              <div class="modal fade" id="modal-lg_bukti<?php echo $data['kode_bayar']; ?>">
                                <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h4 class="modal-title">Bukti Pembayaran</h4>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <hr>
                                    <?php if ($data["bukti_bayar"] == "") : ?>
                                      <div style="text-align: center;">
                                        <img src="../../dist/img/no_image.jpg" style="width: 300px;" class="img-fluid mb-2" alt="">
                                      </div>
                                    <?php else : ?>
                                      <div style="text-align: center;">
                                        <?php
                                        echo '<img  style="width: 300px;" src="data:image/jpeg;base64,' . base64_encode($data['bukti_bayar']) . ' "/>';  ?>
                                      </div>
                                    <?php endif; ?>
                                  </div>
                                </div>
                              </div>
                              <!-- end modal keterangan -->
                            </td>
                            <td class="center"><?php echo "Rp." . number_format($data['jumlah_bayar']) . ",-"; ?></td>
                            <?php if ($data['keterangan'] == "") : ?>
                              <td> -</td>
                            <?php else : ?>
                              <td><?= $data['keterangan']; ?></td>
                            <?php endif; ?>
                            <td>
                              <a class=" btn btn-primary " href="transaksi_bulan_dibayar.php?kode_t_kamar=<?php echo $data['kode_t_kamar']; ?>" data-toggle="tooltip" data-placement="top"><i class="fa fa-info" aria-hidden="true"></i></a>
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

  <!-- Chained Jquery -->
  <script src="../../dist/js/jquery-chained.min.js"></script>

  <!-- Filterizr-->
  <script src="../../vendor/filterizr/jquery.filterizr.min.js"></script>
  <!-- Ekko Lightbox -->
  <script src=".../../vendor/ekko-lightbox/ekko-lightbox.min.js"></script>

  <script>
    $(document).ready(function() {
      $("#kode_t_kamar").chained("#kategori_kos");

    });
  </script>

  <script type="text/javascript">
    <?php echo $jsArray; ?>

    function changeValue(x) {
      document.getElementById('harga').value = prdName[x].harga;
      document.getElementById('pelanggan').value = prdName[x].pelanggan;
      document.getElementById('harga_kamar').value = prdName[x].harga_kamar;
      document.getElementById('kode_kamar').value = prdName[x].kode_kamar;
    };
  </script>

</body>

</html>