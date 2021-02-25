<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_kos");

function tgl_indo($tanggal)
{
	$bulan = array(
		1 => 'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}
function bulan_indo($bulan)
{
	if ($bulan == "2") {
		$bulan = 'Februari';
	} elseif ($bulan == "3") {
		$bulan = 'Maret';
	} elseif ($bulan == "4") {
		$bulan = 'April';
	} elseif ($bulan == "5") {
		$bulan = 'Mei';
	} elseif ($bulan == "6") {
		$bulan = 'Juni';
	} elseif ($bulan == "7") {
		$bulan = 'Juli';
	} elseif ($bulan == "8") {
		$bulan = 'Agustus';
	} elseif ($bulan == "9") {
		$bulan = 'September';
	} elseif ($bulan == "10") {
		$bulan = 'Oktober';
	} elseif ($bulan == "11") {
		$bulan = 'November';
	} elseif ($bulan == "12") {
		$bulan = 'Desember';
	} else {
		$bulan = 'Januari';
	}
	return  $bulan;
}

function tampil_data($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}

	return $rows;
}

function id($query)
{
	global $conn;
	$result = mysqli_query($conn, $query);
	$data = mysqli_fetch_assoc($result);
	return $data;
}

// Function kategori kos
function tambah_kategori_kos($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kategori_kos = htmlspecialchars($data['kategori_kos']);
	// query insert data 
	$query = "INSERT INTO kategori_kos Values 
                ('','$kategori_kos')";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function hapus_kategori_kos($kode_kategori)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM kategori_kos WHERE kode_kategori= '$kode_kategori'");
	return mysqli_affected_rows($conn);
}

function ubah_kategori_kos($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kategori = htmlspecialchars($data['kode_kategori']);
	$kategori_kos = htmlspecialchars($data['kategori_kos']);


	// query ubah data 
	$query = "UPDATE  kategori_kos SET 
	 			kategori_kos= '$kategori_kos' 
	 			WHERE kode_kategori = '$kode_kategori'
				 ";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// Function kamar kos
function tambah_kamar_kos($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kamar = htmlspecialchars($data['kode_kamar']);
	$kode_kategori = htmlspecialchars($data['kode_kategori']);
	$kategori_kos = htmlspecialchars($data['kategori_kos']);
	$kode =  $kode_kamar . $kategori_kos;
	$harga = htmlspecialchars($data['harga']);



	// query insert data 
	$query = "INSERT INTO kamar_kos Values 
				('$kode','$kode_kategori','$harga' )";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function hapus_kamar_kos($kode_kamar)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM kamar_kos WHERE kode_kamar= '$kode_kamar'");
	return mysqli_affected_rows($conn);
}

function ubah_kamar_kos($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kategori = htmlspecialchars($data['kode_kategori']);
	$kode = htmlspecialchars($data['kode']);
	$harga = htmlspecialchars($data['harga']);


	// query ubah data 
	$query = "UPDATE  kamar_kos SET 
	 			kode_kategori= '$kode_kategori',
				harga= '$harga' 
	 			WHERE kode_kamar = '$kode'
				 ";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// Function Akun
function registrasi($data)
{
	global $conn;
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$nama = htmlspecialchars($data['nama']);
	$email = strtolower(stripcslashes($data["email"]));
	$password = mysqli_real_escape_string($conn, $data['password']);
	$password2 = mysqli_real_escape_string($conn, $data['password2']);
	$level = htmlspecialchars($data['level']);
	$status = 0;


	//cek email sudah ada atau belum 
	$result = mysqli_query($conn, "SELECT email FROM akun WHERE email='$email'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
					alert('Email sudah terdaftar')
					</script>";
		return false;
	}

	// cek konfirmasi passsword 
	if ($password !== $password2) {
		echo "<script>
					alert('Konfirmasi password tidak sesuai')
					</script>";
		return false;
	}
	//enkripsi passwordnya
	$password = password_hash($password, PASSWORD_DEFAULT);

	// tambahkan userbaru ke database
	$query1 = "INSERT INTO akun VALUES ('$kode_akun','$nama','$email','$password','$level',$status)";


	mysqli_query($conn, $query1);


	return mysqli_affected_rows($conn);
}

function hapus_akun($kode_akun)
{
	global $conn;

	// query hapus akun
	$query1 = "DELETE FROM akun WHERE kode_akun= '$kode_akun'";
	mysqli_query($conn, $query1);

	return mysqli_affected_rows($conn);
}

function ubah_akun($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$nama = htmlspecialchars($data['nama']);
	$email = strtolower(stripcslashes($data["email"]));
	$password = mysqli_real_escape_string($conn, $data['password']);
	// $password2 = mysqli_real_escape_string($conn, $data['password2']);
	$level = htmlspecialchars($data['level']);

	// query ubah data 
	$query = "UPDATE  akun SET 
	 			nama = '$nama',
				email = '$email',
				password = '$password',
				level = '$level'
	 			WHERE kode_akun = '$kode_akun'
				 ";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


function ganti_password($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$password = mysqli_real_escape_string($conn, $data['password']);
	$password2 = mysqli_real_escape_string($conn, $data['password2']);
	$password3 = mysqli_real_escape_string($conn, $data['password3']);
	$nama = $data['nama'];
	$email = $data['email'];
	$level = $data['level'];


	//cek kecocokan password

	$result = mysqli_query($conn, "SELECT password FROM akun WHERE kode_akun='$kode_akun'");
	$row = mysqli_fetch_assoc($result);

	if (!password_verify($password, $row['password'])) {

		echo "<script>
 				   alert('Kata Sandi Lama Salah')
				   </script>";
		return false;
	}



	// cek konfirmasi passsword 
	if ($password2 !== $password3) {
		echo "<script>
				   alert('Konfirmasi password tidak sesuai')
				   </script>";
		return false;
	}
	//enkripsi passwordnya
	$password2 = password_hash($password2, PASSWORD_DEFAULT);


	// query ubah data 
	$query = "UPDATE  akun SET 
	nama = '$nama',
   email = '$email',
   password = '$password2',
   level = '$level'
	WHERE kode_akun = '$kode_akun'
	";



	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


function validasi($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$status = 1;

	// check apakah data  yang divalidasi pelanggan atau bukan
	$akun = tampil_data("SELECT * FROM akun WHERE kode_akun  = '$kode_akun '")[0];

	if ($akun['level'] == "pelanggan") {
		// query validasi akun 
		$query1 = "UPDATE  akun SET 
	status = $status
	WHERE kode_akun = '$kode_akun'
	";
		mysqli_query($conn, $query1);
		// query validasi pelanggan
		$query = "UPDATE  pelanggan SET 
	statuss = $status
	WHERE kode_akun = '$kode_akun'
	";
		mysqli_query($conn, $query);
	} else {
		// query validasi akun 
		$query1 = "UPDATE  akun SET 
	status = $status
	WHERE kode_akun = '$kode_akun'
	";
		mysqli_query($conn, $query1);
	}


	return mysqli_affected_rows($conn);
}

// Function Pelanggan
function tambah_pelanggan($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$kode_pelanggan = htmlspecialchars($data['kode_pelanggan']);
	$no_hp = htmlspecialchars($data['no_hp']);
	$tgl_daftar = date('Y-m-d');
	$jk = htmlspecialchars($data['jk']);


	$foto_diri = upload_foto_diri();
	$ktp = upload_ktp();

	// query insert data 
	$query = "INSERT INTO pelanggan Values 
				('$kode_pelanggan','$kode_akun','$jk','$no_hp', '$foto_diri', '$ktp', '$tgl_daftar', 0 )";





	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

function upload_foto_diri()
{

	$namaFile = $_FILES['foto_diri']['name'];
	$ukuranFile = $_FILES['foto_diri']['size'];
	$errorFile = $_FILES['foto_diri']['error'];
	$tmpFile = $_FILES['foto_diri']['tmp_name'];

	//cek apakah file yang diuopload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png',];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {

		return false;
	}

	// cek jika ukurannya terlalu besar 
	if ($ukuranFile >  1000000) {
		echo "<script> alert ('Ukuran Gambar Terlalu Besar!!!');
				  </script>";
		return false;
	}

	//lolos pengecekan gambar siap di upload 

	//generate nama file baru
	$foto_gambar = addslashes(file_get_contents($_FILES['foto_diri']['tmp_name']));;

	return $foto_gambar;
}

function upload_ktp()
{

	$namaFile = $_FILES['ktp']['name'];
	$ukuranFile = $_FILES['ktp']['size'];
	$errorFile = $_FILES['ktp']['error'];
	$tmpFile = $_FILES['ktp']['tmp_name'];

	//cek apakah file yang diuopload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png',];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {

		return false;
	}

	// cek jika ukurannya terlalu besar 
	if ($ukuranFile >  1000000) {
		echo "<script> alert ('Ukuran Gambar Terlalu Besar!!!');
				  </script>";
		return false;
	}

	//lolos pengecekan gambar siap di upload 

	//generate nama file baru
	$ktp_gambar = addslashes(file_get_contents($_FILES['ktp']['tmp_name']));;

	return $ktp_gambar;
}

function hapus_pelanggan($kode_pelanggan)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM pelanggan WHERE kode_pelanggan= '$kode_pelanggan'");
	return mysqli_affected_rows($conn);
}



// Function Transaksi Kos
function tambah_transaksi_kos($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kamar = htmlspecialchars($data['kode_kamar']);
	$kode_pelanggan = htmlspecialchars($data['kode_pelanggan']);

	// query insert data 
	$query = "INSERT INTO transaksi_kos Values 
				('','$kode_kamar','$kode_pelanggan' )";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}
function hapus_transaksi_kos($kode_t_kamar)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM transaksi_kos WHERE kode_t_kamar= '$kode_t_kamar'");
	return mysqli_affected_rows($conn);
}

function ubah_transaksi_kos($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_t_kamar = htmlspecialchars($data['kode_t_kamar']);
	$kode_kamar = htmlspecialchars($data['kode_kamar']);
	$kode_pelanggan = htmlspecialchars($data['kode_pelanggan']);


	// query ubah data 
	$query = "UPDATE  transaksi_kos SET 
	 			kode_kamar= '$kode_kamar',
				kode_pelanggan= '$kode_pelanggan' 
	 			WHERE kode_t_kamar = '$kode_t_kamar'
				 ";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// Function Pembayaran
function tambah_transaksi_pembayaran($data)
{

	/**
	 * usahakan uang yang dibayar lebih dari harga kamar kos
	 * atau kalau bisa dibuat kondisi jika uang pembayaran kurang dari kamar kos
	 * maka pembayaran ditolak.
	 * agar data pembayaran tidak membengkak dan tidak ada penghuni yang nyicil
	 * 
	 * ada bug bagian keterangan jika data di hapus baru di input baru
	 */

	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_t_kamar = htmlspecialchars($data['kode_t_kamar']);
	$kode_akun =   htmlspecialchars($data['kode_akun']);
	$tgl_bayar = htmlspecialchars($data['tgl_bayar']);
	$metode_bayar =   htmlspecialchars($data['metode_bayar']);
	$jumlah_bayar = htmlspecialchars($data['jumlah_bayar']);
	$keterangan =   htmlspecialchars($data['keterangan']);
	$kode_bayar =   htmlspecialchars($data['kode_bayar']);
	$bulan_sekarang =   htmlspecialchars($data['bulan']);
	$tahun =   htmlspecialchars($data['tahun']);
	$kode_kas =   htmlspecialchars($data['kode_kas']);
	$tgl_input =   htmlspecialchars($data['tgl_input']);
	$nama_pelanggan =   htmlspecialchars($data['nama_pelanggan']);
	$kode_kamar =   htmlspecialchars($data['kode_kamar']);

	// pecahkan bulan
	$bulan_pecah = explode("-", $bulan_sekarang);
	$bulan = substr($bulan_pecah[0], 2, 3);

	// upload gambar
	$bukti = upload_bukti();

	// Check Harga kamar
	$harga = tampil_data("SELECT harga FROM kamar_kos JOIN transaksi_kos ON transaksi_kos.kode_kamar = kamar_kos.kode_kamar Where kode_t_kamar = '$kode_t_kamar'")[0];
	$harga_kamar = $harga['harga'];


	// Tambah kas
	$jenis = 'Bertambah';
	$sisa_kas = $jumlah_bayar;


	$bulan_utang = $conn->query("SELECT
			`transaksi_bulan_dibayar`.`bulan`,
			`transaksi_bulan_dibayar`.`keterangan`
			FROM
			`transaksi_kos`
			INNER JOIN `transaksi_pembayaran` ON `transaksi_kos`.`kode_t_kamar` =
			`transaksi_pembayaran`.`kode_t_kamar`
			INNER JOIN `transaksi_bulan_dibayar` ON `transaksi_pembayaran`.`kode_bayar` =
			`transaksi_bulan_dibayar`.`kode_bayar`
			WHERE `transaksi_pembayaran`.`kode_t_kamar` = $kode_t_kamar 
			and `transaksi_bulan_dibayar`.`status` = 'belum lunas'
			ORDER BY kode_t_bulan DESC LIMIT 1");



	if ($keterangan == "") {

		// ambil bulan terkahir pembayaran

		/**
		 * $kode_t_kamar
		 * $bulan_sekarang,
		 * $jumlah_bayar,
		 * $bulan_utang,
		 * $harga_kamar
		 */


		$ketenrangann = generateKeterangan_Transaksi();

		$query = $conn->query("SELECT
				`transaksi_bulan_dibayar`.`bulan`
				FROM
				`transaksi_kos`
				INNER JOIN `transaksi_pembayaran` ON `transaksi_kos`.`kode_t_kamar` =
				`transaksi_pembayaran`.`kode_t_kamar`
				INNER JOIN `transaksi_bulan_dibayar` ON `transaksi_pembayaran`.`kode_bayar` =
				`transaksi_bulan_dibayar`.`kode_bayar`
				WHERE `transaksi_pembayaran`.`kode_t_kamar` = $kode_t_kamar 
				ORDER BY kode_t_bulan DESC LIMIT 1
			");

		if ($query->num_rows > 0) {
			$result = $query;
			$result = $result->fetch_assoc();
			$bulan_terakhir = $result['bulan'];
			// $bulan_terakhir = 
		} else {
			$bulan_terakhir = $bulan_sekarang;
		}


		$jumlah_pembayaran = $jumlah_bayar;
		// cek ada bulan yang belum lunas
		if ($bulan_utang->num_rows > 0) {
			$result = $bulan_utang->fetch_assoc();
			$utang = $result['keterangan'];
			$array = explode(".", $utang);
			$sisa_utang = substr($array[1], 0, 3) . '000';
			$jumlah_pembayaran = $jumlah_bayar - $sisa_utang;
			$bulan_selanjutnya = $bulan_terakhir + 1;

			// cek setelah bayar utang bulan apakah uang masih ada
			$keterangann = $jumlah_pembayaran < $harga_kamar ?
				"Pembayaran Atas Nama $nama_pelanggan Untuk Kamar $kode_kamar pada bulan" . bulan_indo($bulan_terakhir) . " dan bulan " . bulan_indo($bulan_selanjutnya) . " masih kurang Rp." . number_format($harga_kamar - $jumlah_pembayaran) . ",-"
				:
				"Pembayaran Atas Nama $nama_pelanggan Untuk Kamar $kode_kamar pada bulan " . bulan_indo($bulan_terakhir) . " dan bulan " . bulan_indo($bulan_selanjutnya) . " lunas";

			if ($jumlah_pembayaran > $harga_kamar) {
				$bulan_pembayaran = ($jumlah_pembayaran / $harga_kamar) + 1;
				goto a; # lompat langsung ke koding yang ada label a.
			}

			goto  b;
		}

		// keterangan untuk pembayaran satu bulan
		if ($jumlah_pembayaran == $harga_kamar) {
			$bulan_terakhir = $query->num_rows > 0 ? $bulan_terakhir + 1 : $bulan_terakhir;
			$keterangann = "Pembayaran Atas Nama $nama_pelanggan Untuk Kamar $kode_kamar Pada Bulan " . bulan_indo($bulan_terakhir) . " Di Bayar Lunas";
		}


		b:
		// keterangan untuk pembayaran lebih dari satu bulan
		if ($jumlah_pembayaran > $harga_kamar) {

			$bulan_terakhir = $query->num_rows > 0 ? $bulan_terakhir + 1 : $bulan_terakhir;
			// jumlah bayar pas atau tidak
			$bulan_pembayaran = $jumlah_pembayaran / $harga_kamar;

			a:

			$selisih = ($jumlah_pembayaran % $harga_kamar) - $harga_kamar;

			$selisih = substr($selisih, 1, 10);
			$selisih = "Rp." . number_format($selisih) . ",-";



			$keterangann = is_int($bulan_pembayaran) ?
				"Pembayaran Atas Nama $nama_pelanggan Untuk Kamar $kode_kamar Di Bayar Lunas untuk bulan " . bulan_indo($bulan_terakhir) . " sampai bulan " . bulan_indo(($bulan_pembayaran + $bulan_terakhir) - 1)
				:
				"Pembayaran Atas Nama $nama_pelanggan Untuk Kamar $kode_kamar pada bulan " . bulan_indo($bulan_terakhir) . " sampai bulan " . bulan_indo(ceil(($bulan_pembayaran + $bulan_terakhir) - 1)) . " masih kurang $selisih";
		}
	}


	// QUERY INSERT KAS
	$query_kas = "INSERT INTO kas Values 
	('$kode_kas','$sisa_kas','$tgl_input','$keterangann','$jenis')";
	mysqli_query($conn, $query_kas);
	// QUERY INSERT TRANSAKSI PEMBAYARAN
	$query1 = "INSERT INTO transaksi_pembayaran Values 
	('$kode_bayar','$kode_t_kamar','$kode_kas','$kode_akun','$tgl_bayar','$metode_bayar','$bukti','$jumlah_bayar','$keterangann')";
	mysqli_query($conn, $query1);

	// ambil bulan yang belum lunas
	$bulan_belum_lunas = $conn->query("SELECT
			`transaksi_bulan_dibayar`.`bulan`,
			`transaksi_bulan_dibayar`.`keterangan`
			FROM
			`transaksi_kos`
			INNER JOIN `transaksi_pembayaran` ON `transaksi_kos`.`kode_t_kamar` =
			`transaksi_pembayaran`.`kode_t_kamar`
			INNER JOIN `transaksi_bulan_dibayar` ON `transaksi_pembayaran`.`kode_bayar` =
			`transaksi_bulan_dibayar`.`kode_bayar`
			WHERE `transaksi_pembayaran`.`kode_t_kamar` = $kode_t_kamar 
			and `transaksi_bulan_dibayar`.`status` = 'belum lunas'
			ORDER BY kode_t_bulan DESC LIMIT 1");


	// cek bulan yang belum lunas
	if ($bulan_belum_lunas->num_rows > 0) {
		// Check apa ada bulan yang belum lunas
		// bayar hutang
		$bulan = $bulan_belum_lunas->fetch_assoc();
		$bulan = $bulan['bulan'];
		$selisih = tampil_data("SELECT * FROM transaksi_bulan_dibayar WHERE status = 'belum lunas' ")[0];
		$sel = $selisih['keterangan'];
		$array = explode(".", $sel);
		$sisa_hutang = substr($array[1], 0, 3) . '000';
		$jumlah_belum_lunas = tampil_data("SELECT jumlah FROM transaksi_bulan_dibayar WHERE status = 'belum lunas' ")[0];
		$lunasi = $jumlah_belum_lunas['jumlah'] + $sisa_hutang;


		// Check tahun  
		$sisa_tahun = id("SELECT max(tahun) AS maxTahun FROM transaksi_bulan_dibayar JOIN `transaksi_pembayaran` ON `transaksi_pembayaran`.`kode_bayar` =`transaksi_bulan_dibayar`.`kode_bayar` 	WHERE `transaksi_pembayaran`.`kode_t_kamar` = $kode_t_kamar");
		$tahun_berjalan = $sisa_tahun['maxTahun'];
		$conn->query("INSERT INTO transaksi_bulan_dibayar Values 
				('','$kode_bayar','$tahun_berjalan','$bulan', '$lunasi','lunas', '$keterangan')");
		$uang_sisa = $jumlah_bayar - $sisa_hutang;
	} else {

		// Check bulan berjalan
		$sisa_bulan = id("SELECT max(bulan) AS maxBulan FROM transaksi_bulan_dibayar JOIN `transaksi_pembayaran` ON `transaksi_pembayaran`.`kode_bayar` =`transaksi_bulan_dibayar`.`kode_bayar` 	WHERE `transaksi_pembayaran`.`kode_t_kamar` = $kode_t_kamar");


		if ($sisa_bulan['maxBulan'] == null) {
			$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
			('','$kode_bayar','$tahun','$bulan', '$harga_kamar','lunas', '$keterangan')";
			mysqli_query($conn, $query2);
			$uang_sisa = $jumlah_bayar - $harga_kamar;
		} else {
			$hasil_bulan = 1 + $sisa_bulan['maxBulan'];
			$bulann = $hasil_bulan;
			// Check apakah bulan sudah lewat tahun 
			if ($hasil_bulan == 13) {
				$tahun = $tahun + 1;
				$bulann = 1;
				$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
				('','$kode_bayar','$tahun','$bulann', '$harga_kamar','lunas', '$keterangan')";
				mysqli_query($conn, $query2);
				$uang_sisa = $jumlah_bayar - $harga_kamar;
			} else {
				$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
				('','$kode_bayar','$tahun','$bulann', '$harga_kamar','lunas', '$keterangan')";
				mysqli_query($conn, $query2);
				$uang_sisa = $jumlah_bayar - $harga_kamar;
			}
		}
	}


	// cek apakah uang sisa masih lebih dari harga kamar
	if ($uang_sisa != 0) {
		if ($uang_sisa >= $harga_kamar) {
			while ($uang_sisa > 0) {
				//set data status
				$status = $uang_sisa > $harga_kamar ? "lunas" : "belum lunas";
				// Check Bulan
				$sisa_bulan = tampil_data("SELECT bulan AS sisa_bulan FROM transaksi_bulan_dibayar WHERE kode_bayar ='$kode_bayar' ORDER BY kode_t_bulan DESC LIMIT 1")[0];

				$hasil_bulan = 1 + $sisa_bulan['sisa_bulan'];
				$bulann = $hasil_bulan;

				//Check apakah bulan sudah lewat tahun atau belum
				if ($hasil_bulan == 13) {
					$tahun = $tahun + 1;
					$bulann = 1;
					if ($uang_sisa >= $harga_kamar) {
						$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
							('','$kode_bayar','$tahun','$bulann', '$harga_kamar','lunas','$keterangan')";
					} else {
						$hutang = $harga_kamar - $uang_sisa;
						$keterangan = "Uang Kurang" . " " . "Rp." . number_format($hutang) . ",-";
						$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
							('','$kode_bayar','$tahun','$bulann', '$uang_sisa','belum lunas','$keterangan')";
					}
				} else {
					if ($uang_sisa >= $harga_kamar) {
						$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
							('','$kode_bayar','$tahun','$bulann', '$harga_kamar','lunas','$keterangan')";
					} else {
						$hutang = $harga_kamar - $uang_sisa;
						$keterangan = "Uang Kurang" . " " . "Rp." . number_format($hutang) . ",-";
						$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
							('','$kode_bayar','$tahun','$bulann', '$uang_sisa','belum lunas','$keterangan')";
					}
				}

				mysqli_query($conn, $query2);
				$uang_sisa -= $harga_kamar;
			}
		} else {
			// Check Bulan
			$sisa_bulan = tampil_data("SELECT bulan AS sisa_bulan FROM transaksi_bulan_dibayar WHERE kode_bayar ='$kode_bayar' ORDER BY kode_t_bulan DESC LIMIT 1")[0];
			$hasil_bulan = 1 + $sisa_bulan['sisa_bulan'];
			$bulann =  $hasil_bulan;

			$hutang = $harga_kamar - $uang_sisa;
			$keterangan = "Uang Kurang" . " " . "Rp." . number_format($hutang) . ",-";
			$query2 = "INSERT INTO transaksi_bulan_dibayar Values 
						('','$kode_bayar','$tahun','$bulann', '$uang_sisa','belum lunas','$keterangan')";

			mysqli_query($conn, $query2);
		}
	}


	return mysqli_affected_rows($conn);
}
function upload_bukti()
{

	$namaFile = $_FILES['bukti']['name'];
	$ukuranFile = $_FILES['bukti']['size'];
	$errorFile = $_FILES['bukti']['error'];
	$tmpFile = $_FILES['bukti']['tmp_name'];

	//cek apakah file yang diuopload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png',];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {

		return false;
	}

	// cek jika ukurannya terlalu besar 
	if ($ukuranFile >  1000000) {
		echo "<script> alert ('Ukuran Gambar Terlalu Besar!!!');
				  </script>";
		return false;
	}

	//lolos pengecekan gambar siap di upload 

	//generate nama file baru
	$bukti_gambar = addslashes(file_get_contents($_FILES['bukti']['tmp_name']));;

	return $bukti_gambar;
}
function hapus_transaksi_bayar($kode_kas)
{
	global $conn;
	$query1 = "DELETE FROM transaksi_pembayaran WHERE kode_kas= '$kode_kas'";
	mysqli_query($conn, $query1);
	$query2 = "DELETE FROM kas WHERE kode_kas= '$kode_kas'";
	mysqli_query($conn, $query2);


	return mysqli_affected_rows($conn);
}

function ubah_transaksi_pembayaran($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_bayar = htmlspecialchars($data['kode_bayar']);
	$kode_t_kamar = htmlspecialchars($data['kode_kamar']);
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$tgl_bayar = htmlspecialchars($data['tgl_bayar']);
	$metode_bayar = htmlspecialchars($data['metode_bayar']);
	$jumlah_bayar = htmlspecialchars($data['jumlah_bayar']);
	$keterangan = htmlspecialchars($data['keterangan']);
	$kode_kas = htmlspecialchars($data['kode_kas']);

	$gambar_lama = tampil_data("SELECT bukti_bayar FROM transaksi_pembayaran WHERE kode_bayar = '$kode_bayar'")[0];


	// cek apakah user pilih gambar baru atau tidak 
	if ($_FILES['bukti']['error'] === 4) {

		$bukti = $gambar_lama['bukti_bayar'];
		// query ubah data 
		$query1 = "UPDATE  transaksi_pembayaran SET 	 			
			kode_t_kamar = '$kode_t_kamar',
			kode_akun ='$kode_akun',
			tgl_bayar = '$tgl_bayar',
			metode_bayar = '$metode_bayar',  
			jumlah_bayar = '$jumlah_bayar',
			keterangan = '$keterangan'
			WHERE kode_bayar = '$kode_bayar'
			";
		mysqli_query($conn, $query1);
	} else {
		$bukti = upload_bukti();
	}
	// query ubah data 
	$query2 = "UPDATE  transaksi_pembayaran SET 	 			
	kode_t_kamar = '$kode_t_kamar',
	kode_akun ='$kode_akun',
	tgl_bayar = '$tgl_bayar',
	metode_bayar = '$metode_bayar',
	bukti_bayar = '$bukti',
	jumlah_bayar = '$jumlah_bayar',
	keterangan = '$keterangan'
	WHERE kode_bayar = '$kode_bayar'
	";
	mysqli_query($conn, $query2);

	return mysqli_affected_rows($conn);
}

// Function Pembayaran perbulan
function tambah_transaksi_bulan_dibayar($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_bayar = htmlspecialchars($data['kode_bayar']);
	$tahun = htmlspecialchars($data['tahun']);
	$bulan = htmlspecialchars($data['bulan']);



	// query insert data 
	$query1 = "INSERT INTO transaksi_bulan_dibayar Values 
				('','$kode_bayar','$tahun','$bulan')";
	mysqli_query($conn, $query1);

	return mysqli_affected_rows($conn);
}

function hapus_transaksi_bulan_dibayar($kode_t_bulan)
{
	global $conn;
	mysqli_query($conn, "DELETE FROM transaksi_bulan_dibayar WHERE kode_t_bulan= '$kode_t_bulan'");
	return mysqli_affected_rows($conn);
}

// Function pengeluaran
function tambah_transaksi_pengeluaran($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kas = htmlspecialchars($data['kode_kas']);
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$tgl_input = htmlspecialchars($data['tgl_input']);
	$jumlah_pengeluaran = htmlspecialchars($data['jumlah_pengeluaran']);
	$keterangan = htmlspecialchars($data['keterangan']);

	// upload gambar
	$bukti = upload_bukti();

	// Tambah kas
	$jenis = 'Berkurang';
	$sisa_kas = $jumlah_pengeluaran;

	// query insert KAS
	$query_kas = "INSERT INTO kas Values 
	('$kode_kas','$sisa_kas','$tgl_input','$keterangan','$jenis')";
	mysqli_query($conn, $query_kas);

	$query_pengeluaran = "INSERT INTO transaksi_pengeluaran Values 
				('','$kode_akun', '$kode_kas','$tgl_input','$jumlah_pengeluaran','$keterangan','$bukti' )";


	mysqli_query($conn, $query_pengeluaran);
	return mysqli_affected_rows($conn);
}

function hapus_transaksi_pengeluaran($kode_kas)
{
	global $conn;
	$query1 = "DELETE FROM transaksi_pengeluaran WHERE kode_kas= '$kode_kas'";
	mysqli_query($conn, $query1);
	$query2 = "DELETE FROM kas WHERE kode_kas= '$kode_kas'";
	mysqli_query($conn, $query2);


	return mysqli_affected_rows($conn);
}

function ubah_transaksi_pengeluaran($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kas = htmlspecialchars($data['kode_kas']);
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$tgl_input = htmlspecialchars($data['tgl_input']);
	$jumlah_pengeluaran = htmlspecialchars($data['jumlah_pengeluaran']);
	$keterangan = htmlspecialchars($data['keterangan']);
	$kode_pengeluaran = htmlspecialchars_decode($data['kode_pengeluaran']);
	$gambar_lama = tampil_data("SELECT bukti_nota FROM transaksi_pengeluaran WHERE kode_pengeluaran = '$kode_pengeluaran'")[0];

	// cek apakah user pilih gambar baru atau tidak 
	if ($_FILES['bukti']['error'] === 4) {

		$bukti = $gambar_lama['bukti_nota'];
		// query ubah data 

		$query_edit_kas = "UPDATE  kas SET
			 sisa_kas = '$jumlah_pengeluaran',
			 keterangan = '$keterangan' 
			 WHERE kode_kas = '$kode_kas'
			 ";
		mysqli_query($conn, $query_edit_kas);

		$query1 = "UPDATE  transaksi_pengeluaran SET
			tgl_input = '$tgl_input',
			jumlah_pengeluaran ='$jumlah_pengeluaran',
			keterangan = '$keterangan'
			WHERE kode_pengeluaran = '$kode_pengeluaran'
			";
		mysqli_query($conn, $query1);
	} else {
		$bukti = upload_bukti();

		// query ubah data 
		$query_edit_kas = "UPDATE  kas SET
	sisa_kas = '$jumlah_pengeluaran',
	keterangan = '$keterangan' 
	WHERE kode_kas = '$kode_kas'
	";
		mysqli_query($conn, $query_edit_kas);

		$query2 = "UPDATE  transaksi_pengeluaran SET 	 			
	tgl_input = '$tgl_input',
	jumlah_pengeluaran ='$jumlah_pengeluaran',
	keterangan = '$keterangan',
	bukti_nota = '$bukti'
	WHERE kode_pengeluaran = '$kode_pengeluaran'
	";
		mysqli_query($conn, $query2);
	}

	return mysqli_affected_rows($conn);
}


function tambah_setoran($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kas = htmlspecialchars($data['kode_kas']);
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$tgl_input = htmlspecialchars($data['tgl_input']);
	$jumlah_setoran = htmlspecialchars($data['jumlah_setoran']);
	$keterangan = htmlspecialchars($data['keterangan']);
	$tgl_store = htmlspecialchars($data['tgl_store']);

	// jika keterangan kosong 
	if ($keterangan = ' ') {
		$keterangan = "Setoran kos untuk tanggal " . tgl_indo($tgl_store);
	}

	// upload gambar
	$bukti = upload_bukti();

	// Tambah kas
	$jenis = 'Berkurang';
	$sisa_kas = $jumlah_setoran;

	// query insert KAS
	$query_kas = "INSERT INTO kas Values 
	('$kode_kas','$sisa_kas','$tgl_input','$keterangan','$jenis')";
	mysqli_query($conn, $query_kas);

	$query_storean = "INSERT INTO setoran_owner Values 
				('','$kode_akun', '$kode_kas','$tgl_store','$jumlah_setoran','$keterangan','$bukti' )";




	mysqli_query($conn, $query_storean);
	return mysqli_affected_rows($conn);
}

function ubah_setoran($data)
{
	global $conn;
	// ambil data dari tiap elemen dalam form 
	$kode_kas = htmlspecialchars($data['kode_kas']);
	$kode_akun = htmlspecialchars($data['kode_akun']);
	$tgl_store = htmlspecialchars($data['tgl_store']);
	$jumlah_setoran = htmlspecialchars($data['jumlah_setoran']);
	$keterangan = htmlspecialchars($data['keterangan']);
	$kode_setoran = htmlspecialchars($data['kode_setoran']);
	$gambar_lama = tampil_data("SELECT bukti_store FROM setoran_owner WHERE kode_setoran = '$kode_setoran'")[0];


	// cek apakah user pilih gambar baru atau tidak 
	if ($_FILES['bukti']['error'] === 4) {

		$bukti = $gambar_lama['bukti_store'];
		// query ubah data 
		$query_edit_kas = "UPDATE  kas SET
			 sisa_kas = '$jumlah_setoran',
			 keterangan = '$keterangan' 
			 WHERE kode_kas = '$kode_kas'
			 ";
		mysqli_query($conn, $query_edit_kas);

		$query1 = "UPDATE setoran_owner SET
			tgl_store = '$tgl_store',
			jumlah_store ='$jumlah_setoran',
			keterangan = '$keterangan'
			WHERE kode_setoran = '$kode_setoran'
			";
		mysqli_query($conn, $query1);
	} else {
		$bukti = upload_bukti();

		// query ubah data 
		$query_edit_kas = "UPDATE  kas SET
	sisa_kas = '$jumlah_setoran',
	keterangan = '$keterangan' 
	WHERE kode_kas = '$kode_kas'
	";
		mysqli_query($conn, $query_edit_kas);

		$query2 = "UPDATE  setoran_owner SET 	 			
	tgl_store = '$tgl_store',
	jumlah_store ='$jumlah_setoran',
	keterangan = '$keterangan',
	bukti_store = '$bukti'
	WHERE kode_setoran = '$kode_setoran'
	";
		mysqli_query($conn, $query2);
	}



	return mysqli_affected_rows($conn);
}
