<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

$id_brg = $_GET['id_brg'];

$query = $mysqli->prepare("DELETE FROM barang WHERE id_brg = ?");
$query->bind_param("s", $id_brg);

// Mendapatkan nama gambar lama
$query_get_old_image = "SELECT foto FROM barang WHERE id_brg='$id_brg'";
$result_get_old_image = $mysqli->query($query_get_old_image);
$row_old_image = $result_get_old_image->fetch_assoc();
$old_image_path = "../../images/barang/" . $row_old_image['foto'];

// Hapus gambar lama jika ada
if (file_exists($old_image_path)) {
	unlink($old_image_path);
}

if ($query->execute()) {		
	echo "<script>alert('Barang berhasil dihapus.'); window.location='alat.php';</script>";
	exit();
} else {	
	echo "<script>alert('Gagal menghapus barang: " . $mysqli->error . "'); window.location='alat.php';</script>";
	exit();
}

$query->close();
?>