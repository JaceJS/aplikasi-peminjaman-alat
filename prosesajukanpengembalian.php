<?php
session_start();

require_once("config/koneksi.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'anggota') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {            
    $id_peminjaman = $_POST['id_peminjaman'];    
        
    $peminjamanQuery = "UPDATE peminjaman SET status_pengajuan = 'Diajukan' WHERE id_peminjaman = $id_peminjaman";
    $mysqli->query($peminjamanQuery);    
    
    echo "<script>alert('Data berhasil diajukan.'); window.location='riwayatpeminjaman.php';</script>";
    exit();
} else {    
    header("Location: index.php");
    exit();
}
?>
