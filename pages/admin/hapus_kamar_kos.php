<?php 

require 'functions.php';

$kode_kamar= $_GET['kode_kamar'];
if (hapus_kamar_kos ($kode_kamar) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='kamar_kos.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='kamar_kos.php';
			</script>";	
	}


 ?>