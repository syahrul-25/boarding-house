<?php 

require 'functions.php';

$kode_akun= $_GET['kode_akun'];
if (hapus_akun ($kode_akun) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='akun.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='akun.php';
			</script>";	
	}


 ?>