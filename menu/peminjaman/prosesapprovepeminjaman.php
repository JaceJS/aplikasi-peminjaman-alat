<?php
session_start();

require_once("../../config/koneksi.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {     
    $id_peminjaman = $_POST["id_peminjaman"];
    $id_brg = $_POST["id_brg"];
    $id_anggota = $_POST["id_anggota"];
    $kuantitas = $_POST["kuantitas"];
    $tgl_pinjam = $_POST["tgl_pinjam"];
    $aksi_pengajuan = $_POST["aksi_pengajuan"];

    if ($aksi_pengajuan === "Disetujui") {
        $barangQuery = "UPDATE barang SET stok_brg = stok_brg - $kuantitas WHERE id_brg IN (SELECT id_brg FROM peminjaman WHERE id_peminjaman = $id_peminjaman)";
        $peminjamanQuery = "UPDATE peminjaman SET status_peminjaman = 1 WHERE id_peminjaman = $id_peminjaman";

        $mysqli->query($barangQuery);
        $mysqli->query($peminjamanQuery);
        
        echo "<script>alert('Data berhasil disetujui.'); window.location='peminjaman.php';</script>";
        exit();
    } else if ($aksi_pengajuan === "Ditolak") {
        $peminjamanQuery = "UPDATE peminjaman SET status_peminjaman = 2 WHERE id_peminjaman = $id_peminjaman";

        $mysqli->query($peminjamanQuery);

        echo "<script>alert('Data ditolak.'); window.location='peminjaman.php';</script>";
        exit();
    }
} else {    
    header("Location: index.php");
    exit();
}
?>
