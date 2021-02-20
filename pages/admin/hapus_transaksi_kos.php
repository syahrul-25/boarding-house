<?php 

require 'functions.php';

$kode_t_kamar= $_GET['kode_t_kamar'];
if (hapus_transaksi_kos ($kode_t_kamar) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='transaksi_kos.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='transaksi_kos.php';
			</script>";	
	}


 ?>