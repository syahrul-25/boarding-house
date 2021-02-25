<?php 
session_start(); 
require 'functions.php';
if (!isset($_SESSION["level"])=="superadmin") {
	header("Location: ../login.php");
  exit;
  }

// ambil data di URL 
$kode_akun = $_GET['kode_akun'];
  
//query data 
$akun=tampil_data ("SELECT * FROM akun WHERE kode_akun  = '$kode_akun '") [0];	
 

// cek apakah berhasil di tambahkan atau tidak
 if (validasi ($_GET) > 0) {
 
 
   echo "<script> 
       alert('Akun Berhasil Divalidasi!');
       document.location.href='akun.php';
     </script>";	
 } else {
   echo "<script> 
       alert('Akun Gagal Divalidasi!');
       document.location.href='akun.php';
     </script>";	
 } 