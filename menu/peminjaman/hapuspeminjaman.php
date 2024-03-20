<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

$id_peminjaman = $_GET['id_peminjaman'];

$query = $mysqli->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ?");
$query->bind_param("s", $id_peminjaman);

if ($query->execute()) {	
	echo "<script>alert('Data berhasil dihapus.'); window.location='peminjaman.php';</script>";
	$query->close();
	exit();
} else {	
	echo "<script>alert('Gagal menghapus data: " . $mysqli->error . "'); window.location='peminjaman.php';</script>";
	exit();
}


?>