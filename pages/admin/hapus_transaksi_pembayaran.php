<?php 

require 'functions.php';

$kode_kas= $_GET['kode_kas'];
if (hapus_transaksi_bayar ($kode_kas) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='transaksi_pembayaran.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='transaksi_pembayaran.php';
			</script>";	
	}


 ?>