<?php 

require 'functions.php';

$kode_kas= $_GET['kode_kas'];
if (hapus_transaksi_pengeluaran ($kode_kas) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='transaksi_pengeluaran.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='transaksi_pengeluaran.php';
			</script>";	
	}


 ?>