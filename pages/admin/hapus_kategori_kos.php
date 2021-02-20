<?php 

require 'functions.php';

$kode_kategori= $_GET['kode_kategori'];
if (hapus_kategori_kos ($kode_kategori) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='kategori_kos.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='kategori_kos.php';
			</script>";	
	}


 ?>