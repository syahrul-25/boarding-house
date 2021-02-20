<?php 
session_start();
if (!isset($_SESSION["level"])=="admin") {
	header("Location: ../login.php");
  exit;
  }
  require '../admin/functions.php';

// ambil data di URL 
$kode_bayar = $_GET['kode_bayar'];
//query data
$transaksi_bayar=tampil_data ("SELECT * FROM transaksi_pembayaran JOIN akun ON akun.kode_akun = transaksi_pembayaran.kode_akun JOIN transaksi_kos ON transaksi_kos.kode_t_kamar = transaksi_pembayaran.kode_t_kamar JOIN kamar_kos ON kamar_kos.kode_kamar = transaksi_kos.kode_kamar JOIN kategori_kos ON kategori_kos.kode_kategori = kamar_kos.kode_kategori WHERE kode_bayar = '$kode_bayar' ORDER BY tgl_bayar ")[0];

// cek apakah tombol submit sudah ditekan atau belum
if (isset($_POST["ubah"])) {

  // cek apakah berhasil di tambahkan atau tidak
 if (ubah_transaksi_pembayaran ($_POST) > 0) {
   echo "<script> 
       alert('Data Berhasil Diubah!');
       document.location.href='transaksi_pembayaran.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Data Gagal Diubah!');
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
            <h1>Edit Transaksi Pembayaran</h1>
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
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Transaksi Pembayaran</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                <div class="form-group">           
                <input type="hidden" name="kode_bayar" value="<?= $transaksi_bayar['kode_bayar']; ?>"> 
                <input type="hidden" name="kode_akun" value="<?= $transaksi_bayar['kode_akun']; ?>"> 
                <input type="text" name="kode_kas" value="<?= $transaksi_bayar['kode_kas']; ?>">      
                    <label for="kategori_kos">kategori Kos</label>
                    <select name="kode_kategori" id="kategori_kos"   class="form-control" required="required">
                       <?php
                       $kategori_kos=tampil_data ("SELECT * FROM kategori_kos");	  
                       foreach ($kategori_kos as $data) :
                                if ($transaksi_bayar['kode_kategori']==$data['kode_kategori']) {
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
                  $kode_kategori = $transaksi_bayar["kode_kategori"];  
                  $kode_kamar =tampil_data ("SELECT * FROM transaksi_kos 
                                            JOIN  kamar_kos ON kamar_kos.kode_kamar = transaksi_kos.kode_kamar  JOIN kategori_kos ON kategori_kos.kode_kategori = kamar_kos.kode_kategori  ");	 
                            
                
                 foreach ($kode_kamar as $data) :
                          if ($transaksi_bayar['kode_t_kamar']==$data['kode_t_kamar']) {
                              $select="selected";
                              }else{
                              $select="";
                              }
                              ?>
                  <option  id="kode_kamar" class="<?php echo $data['kode_kategori']; ?>"value="<?= $data['kode_t_kamar'];?>"
                  <?= $select;?>><?= $data['kode_kamar'];?></option>
                  <?php  endforeach; ?>
              </select>                  
          </div> 
                <div class="form-group">               
                    <label for="tgl_bayar">Tanggal Bayar</label>
                    <input type="date" class="form-control" name="tgl_bayar" value="<?= $transaksi_bayar['tgl_bayar']; ?>" required>           
                </div>

                <div class="form-group">               
                    <label for="metode_bayar">Metode Bayar</label><br>
                    <?php 
                    if ($transaksi_bayar['metode_bayar']=='cash')  
                      echo "<input type='radio' id='Cash' name='metode_bayar' value='cash'  checked> 
                      <label for='Cash' style='margin-right: 10px;'>Cash</label>
                      <input type='radio' id='Transfer' name='metode_bayar' value='transfer'>                  
                      <label for='transfer' style='margin-right: 10px;'>Transfer</label>
                      ";
                    else   echo "
                    <input type='radio' id='Cash' name='metode_bayar' value='cash'> 
                    <label for='Cash' style='margin-right: 10px;'>Cash</label>
                    <input type='radio' id='Transfer' name='metode_bayar' value='transfer' checked>                  
                    <label for='transfer' style='margin-right: 10px;'>Transfer</label>" ;
                    ?>
                    
                    
                   <br>   
                </div> 

                <div class="form-group">
               
                  <label for="gambar">Bukti Bayar</label> <br> 
                  <?php if ($transaksi_bayar["bukti_bayar"]=="") : ?>
                    <a  href="../../dist/img/no_image.jpg" data-toggle="lightbox"> 
                    <img src="../../dist/img/no_image.jpg" width=70;></a><br> <br>
                  <?php else :?>   
                     <?php  echo '<img  style="width: 400px;" src="data:image/jpeg;base64,'.base64_encode( $transaksi_bayar['bukti_bayar'] ).' "/>';  ?><br> <br>
                  <?php endif; ?> 
             
                  <input type="file" class="form-control-file" id="gambar" name="bukti">
               </div> 

                <div class="form-group">               
                    <label for="jumlah">Jumlah Bayar</label>
                    <input type="input" class="form-control-file" name="jumlah_bayar" value="<?= $transaksi_bayar['jumlah_bayar']; ?>">           
                </div>
                
                <div class="form-group">               
                    <label for="keterangan">Keterangan</label><br>
                    <textarea name="keterangan" id="keterangan" name="keterangan" cols="60" rows="10" ><?= $transaksi_bayar['keterangan']; ?></textarea>         
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
