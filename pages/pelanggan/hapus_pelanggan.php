<?php 

require '../admin/functions.php';

$kode_pelanggan= $_GET['kode_pelanggan'];
if (hapus_pelanggan ($kode_pelanggan) >0) {
	 echo "<script> 
				alert('Data Berhasil Dihapus!');
				document.location.href='pelanggan.php';
			</script>";	
	} else {
		echo "<script> 
				alert('Data Gagal Dihapus!');
				document.location.href='pelanggan.php';
			</script>";	
	}


 ?>