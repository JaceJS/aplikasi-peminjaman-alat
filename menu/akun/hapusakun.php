<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

$id_akun = $_GET['id_akun'];

$query = $mysqli->prepare("DELETE FROM users WHERE id = ?");
$query->bind_param("s", $id_akun);

if ($query->execute()) {	
	echo "<script>alert('Data berhasil dihapus.'); window.location='akun.php';</script>";
	exit();
} else {	
	echo "<script>alert('Gagal menghapus data: " . $mysqli->error . "'); window.location='akun.php';</script>";
	exit();
}

$query->close();
?>