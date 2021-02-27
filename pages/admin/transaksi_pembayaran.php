<?php
session_start();
require 'functions.php';
if (!isset($_SESSION["level"]) == "superadmin") {
  header("Location: ../login.php");
  exit;
}
$transaksi_bayar = tampil_data("SELECT
      `transaksi_pembayaran`.*,
      `kategori_kos`.`kategori_kos`
      FROM
      `transaksi_pembayaran`
      INNER JOIN `transaksi_kos` ON `transaksi_pembayaran`.`kode_t_kamar` =
      `transaksi_kos`.`kode_t_kamar`
      INNER JOIN `kamar_kos` ON `transaksi_kos`.`kode_kamar` =
      `kamar_kos`.`kode_kamar`
      INNER JOIN `kategori_kos` ON `kamar_kos`.`kode_kategori` =
      `kategori_kos`.`kode_kategori`");



// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["submit"])) {

  // cek apakah berhasil di tambahkan atau tidak
  $tambah_transaksi = tambah_transaksi_pembayaran($_POST);
  $pesan = $tambah_transaksi["pesan"];
  echo "<script> 
      alert('$pesan');
      document.location.href='transaksi_pembayaran.php';
    </script>";
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
              <h1>Transaksi Pembayaran</h1>
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
                <div class="card-header">
                  <h3 class="card-title">Data Transaksi Pembayaran</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="card-header  ">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                      Tambah Data Transaksi Pembayaran
                    </button>
                    <div class="modal fade" id="modal-default">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Form Tambah data Transaksi Pembayaran</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <!-- form start -->
                          <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                              <div class="form-group">
                                <input type="hidden" value="<?= $kodeBayar; ?>" name="kode_bayar">
                                <input type="hidden" name="bulan" value="<?php echo date('m'); ?>">
                                <input type="hidden" name="tahun" value="<?php echo date('Y'); ?>">
                                <input type="hidden" name="kode_kas" value="<?= $kodeKas; ?>">
                                <input type="hidden" name="tgl_input" value="<?= date('Y-m-d')  ?>">
                                <input type="hidden" name="kode_kamar" id="kode_kamar">
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

                              <input type="hidden" name="penginput" value="<?= $nama; ?>">

                              <div class="form-group">
                                <label for="sumber">Kategori Kos</label>
                                <select name="kategori_kos" id="kategori_kos" class="form-control">
                                  <option value="">Pilih Kategori Kos</option>
                                  <?php $kategori = tampil_data("SELECT * FROM kategori_kos ORDER BY kategori_kos");
                                  foreach ($kategori as $row) : ?>
                                    <option value="<?php echo $row['kode_kategori']; ?>">
                                      <?php echo $row['kategori_kos']; ?>
                                    </option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="kode_kamar">Nomor Kamar</label>
                                <select name="kode_t_kamar" id="kode_t_kamar" class="form-control" required="required" onchange="changeValue(this.value)">
                                  <option value="">Pilih Nomor Kamar</option>
                                  <?php
                                  $kamar = tampil_data("SELECT * FROM transaksi_kos 
                                          JOIN kamar_kos 
                                          ON kamar_kos.kode_kamar
                                          = transaksi_kos.kode_kamar
                                          JOIN  kategori_kos
                                          ON kategori_kos.kode_kategori 
                                          = kamar_kos.kode_kategori");
                                  foreach ($kamar as $row) : ?>
                                    <option id="kode_t_kamar" class="<?php echo $row['kode_kategori']; ?>" value="<?php echo $row['kode_t_kamar']; ?>">
                                      <?php echo $row['kode_kamar']; ?>
                                    </option>
                                  <?php endforeach; ?>

                                  <?php
                                  $detail = tampil_data("SELECT * FROM transaksi_kos JOIN kamar_kos ON kamar_kos.kode_kamar = transaksi_kos.kode_kamar JOIN pelanggan ON pelanggan.kode_pelanggan = transaksi_kos.kode_pelanggan JOIN akun ON akun.kode_akun = pelanggan.kode_akun");

                                  $jsArray = "var prdName = new Array();\n";
                                  foreach ($detail as $data) {
                                    $jsArray .= "prdName['" . $data['kode_t_kamar'] . "'] = {harga:'" . addslashes("Rp." . number_format($data['harga']) . ",-") . "', pelanggan:'" . addslashes($data['nama']) . "',harga_kamar:'" . addslashes($data['harga']) . "',kode_kamar:'" . addslashes($data['kode_kamar']) . "' };\n";
                                  }
                                  ?>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="harga">Harga Kamar</label>
                                <input type="text" class="form-control" name="harga" id="harga" readonly>
                                <input type="hidden" class="form-control" name="harga_kamar" id="harga_kamar" readonly>
                              </div>

                              <div class="form-group">
                                <label for="pelanggan">Nama Pelanggan</label>
                                <input type="text" class="form-control" name="nama_pelanggan" id="pelanggan" readonly>
                              </div>

                              <div class="form-group">
                                <label for="tgl_bayar">Tanggal Bayar</label>
                                <input type="date" class="form-control" name="tgl_bayar" required>
                              </div>


                              <div class="form-group">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control" name="jumlah_bayar" required autocomplete="off">
                              </div>

                              <div class="form-group">
                                <label for="metode_bayar">Metode Bayar</label><br>
                                <input type="radio" id="Cash" name="metode_bayar" value="cash" required>
                                <label for="Cash" style="margin-right: 10px;">Cash</label>
                                <input type="radio" id="Transfer" name="metode_bayar" value="transfer" required>
                                <label for="Transfer">Transfer</label><br>
                              </div>

                              <div class="form-group">
                                <label for="bukti">Bukti Pembayaran</label>
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
                          <th width=1;>No</th>
                          <th>Penginput</th>
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
                            <td> <?= $data['penginput']; ?></td>
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
                                        <img src="../../dist/img/no_image.jpg" style="width: 400px;" class="img-fluid mb-2" alt="">
                                      </div>
                                    <?php else : ?>
                                      <div style="text-align: center;">
                                        <?php
                                        echo '<img  style="width: 400px;" src="data:image/jpeg;base64,' . base64_encode($data['bukti_bayar']) . ' "/>';  ?>
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
                              <a class="fas fa-edit btn btn-success " href="edit_transaksi_pembayaran.php?kode_bayar=<?php echo $data['kode_bayar']; ?>" data-toggle="tooltip" data-placement="top"></a>
                              <a onclick="return confirm('Yakin ingin menghapus data ini')" href="hapus_transaksi_pembayaran.php?kode_kas=<?php echo $data['kode_kas']; ?>" class="fas fa-trash-alt btn btn-danger"></a>
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