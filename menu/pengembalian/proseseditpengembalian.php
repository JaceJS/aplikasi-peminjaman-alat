<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$id_pengembalian = $_GET['id_pengembalian'];
	$tgl_kembali = htmlspecialchars($_POST['tgl_kembali']);
	$catatan = $_POST['catatan'];

	$query = $mysqli->query("SELECT * FROM pengembalian WHERE id_pengembalian='$id_pengembalian'");
	$data_pengembalian = mysqli_fetch_assoc($query);

	$sql = "SELECT peminjaman.tgl_pinjam FROM peminjaman JOIN pengembalian ON peminjaman.id_peminjaman = pengembalian.id_peminjaman WHERE pengembalian.id_peminjaman = '$data_pengembalian[id_peminjaman]'";
	$query = $mysqli->query($sql);
	$data_peminjaman = mysqli_fetch_assoc($query);

	$today = date("d-M-Y h:i A");
	
	if ($tgl_kembali < $data_peminjaman['tgl_pinjam']){
        echo "<script>alert('Tanggal kembali tidak boleh sebelum tanggal pinjam.'); window.location='editpengembalian.php?id_pengembalian=$id_pengembalian';</script>";
        exit();
    }

	if (empty($tgl_kembali)) {
		echo "<script>alert('Tanggal kembali tidak boleh kosong.'); window.location='editpengembalian.php?id_pengembalian=$id_pengembalian';</script>";
		exit();
	}    
	
	$query = "UPDATE pengembalian SET tgl_kembali='$tgl_kembali', catatan='$catatan' WHERE id_pengembalian='$id_pengembalian'";
	
	if ($mysqli->query($query)) {        
		echo "<script>alert('Pengembalian berhasil diupdate.'); window.location='pengembalian.php';</script>";            
		exit();
	} else {        
		echo "<script>alert('Gagal melakukan proses edit pengembalian: " . $mysqli->error . "')</script>";
		exit();
	}

} else {    
	header("location: pengembalian.php");
	exit();
}

?>