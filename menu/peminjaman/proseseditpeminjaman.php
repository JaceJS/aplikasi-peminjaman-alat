<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_peminjaman = $_GET['id_peminjaman'];
    $id_brg = $_POST['barang'];
	$id_anggota = $_POST['peminjam'];
	$tgl_pinjam = $_POST['tgl_pinjam'];
	$status = $_POST['status'];
	$catatan = $_POST['catatan'];

	$sql = "SELECT * FROM peminjaman WHERE id_peminjaman='$id_peminjaman'";
	$data_peminjaman = mysqli_fetch_assoc($mysqli->query($sql));

	$sql = "SELECT * FROM pengembalian WHERE id_peminjaman='$id_peminjaman'";
	$data_pengembalian = mysqli_fetch_assoc($mysqli->query($sql));

	if ($status == 1 && $id_peminjaman != $data_pengembalian['id_peminjaman']) {
		$tgl_kembali = date('Y-m-d');
		$insert = "INSERT INTO pengembalian (id_brg, id_peminjaman, id_anggota, tgl_kembali) VALUES ('$id_brg', '$id_peminjaman', '$id_anggota', '$tgl_kembali')";
		$mysqli->query($insert) or die('gagal menambah data pengembalian');
	}


	$query = "UPDATE peminjaman SET id_brg='$id_brg', id_anggota='$id_anggota', tgl_pinjam='$tgl_pinjam', status='$status', catatan='$catatan' WHERE id_peminjaman='$id_peminjaman'";	

	if ($mysqli->query($query)) {        
		echo "<script>alert('Data berhasil diupdate.'); window.location='peminjaman.php';</script>";            
		exit();
	} else {        
		echo "<script>alert('Gagal melakukan proses edit data: " . $mysqli->error . "')</script>";
		exit();
	}	

	
} else {    
    header("location: peminjaman.php");
    exit();
}
?>