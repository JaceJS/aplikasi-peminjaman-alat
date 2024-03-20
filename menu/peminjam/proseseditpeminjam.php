<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_peminjam = $_GET['id_peminjam'];
    $username = htmlspecialchars($_POST['username']); 
    $divisi = $_POST['divisi'];
	$kontak = intval($_POST['phone']);

	if (!preg_match("/^[0-9]{10,15}$/", $kontak)) {
        echo "<script>alert('Nomor telepon tidak valid.'); window.location.href='editpeminjam.php?id_peminjam=$id_peminjam';</script>";
        exit();
    }
	
	$query = "UPDATE anggota SET nama='$username', divisi='$divisi', kontak='$kontak' WHERE id_anggota='$id_peminjam'";
    
    if ($mysqli->query($query)) {        
        echo "<script>alert('Anggota berhasil diupdate.'); window.location='peminjam.php';</script>";            
        exit();
    } else {        
        echo "<script>alert('Gagal melakukan proses edit Anggota: " . $mysqli->error . "')</script>";
        exit();
    }

} else {    
    header("location: peminjam.php");
    exit();
}
?>
