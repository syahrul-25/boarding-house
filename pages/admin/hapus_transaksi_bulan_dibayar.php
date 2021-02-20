<?php 

require 'functions.php';

$kode_t_bulan= $_GET['kode_t_bulan'];


$kode_bayar=tampil_data ("SELECT kode_bayar FROM transaksi_bulan_dibayar WHERE kode_t_bulan  = '$kode_t_bulan '")[0];
 
$bayar = $kode_bayar['kode_bayar'];
 
if (hapus_transaksi_bulan_dibayar ($kode_t_bulan) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='transaksi_bulan_dibayar.php?kode_bayar=$bayar';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='transaksi_bulan_dibayar.php?kode_bayar=$bayar';
			</script>";	
	}


 ?>