<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

$id_peminjam = $_GET['id_peminjam'];

$query = $mysqli->prepare("DELETE FROM anggota WHERE id_anggota = ?");
$query->bind_param("s", $id_peminjam);

if ($query->execute()) {	
	echo "<script>alert('Anggota berhasil dihapus.'); window.location='peminjam.php';</script>";
	exit();
} else {	
	echo "<script>alert('Gagal menghapus anggota: " . $mysqli->error . "'); window.location='peminjam.php';</script>";
	exit();
}

$query->close();
?>