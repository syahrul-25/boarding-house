<?php 
 // mengaktifkan session
session_start();

//tambahkan array kosong pada session
$_SESSION=[];

// unset session
session_unset();


// menghapus semua session
session_destroy();

// mengalihkan halaman sambil mengirim pesan logout
header("location:../login.php");
exit;
 ?>