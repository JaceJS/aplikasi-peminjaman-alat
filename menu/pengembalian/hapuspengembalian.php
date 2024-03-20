<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

$id_pengembalian = $_GET['id_pengembalian'];

$query = $mysqli->prepare("DELETE FROM pengembalian WHERE id_pengembalian = ?");
$query->bind_param("s", $id_pengembalian);

if ($query->execute()) {	
	echo "<script>alert('Data berhasil dihapus.'); window.location='pengembalian.php';</script>";
	exit();
} else {	
	echo "<script>alert('Gagal menghapus data: " . $mysqli->error . "'); window.location='pengembalian.php';</script>";
	exit();
}

$query->close();
?>