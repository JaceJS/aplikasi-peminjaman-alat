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
    $aksi_pengajuan = $_POST["aksi_pengajuan"];
    $status_pengajuan = $_POST["aksi_pengajuan"];
    // $kuantitas = $_POST["kuantitas"];

    if ($aksi_pengajuan === "Disetujui") {
        $barangQuery = "UPDATE barang SET stok_brg = 1 WHERE id_brg IN (SELECT id_brg FROM peminjaman WHERE id_peminjaman = $id_peminjaman)";
        $peminjamanQuery = "UPDATE peminjaman SET status = 1, aksi_pengajuan = '$aksi_pengajuan', status_pengajuan = '$status_pengajuan' WHERE id_peminjaman = $id_peminjaman";
        $pengembalianQuery = "INSERT INTO pengembalian (id_brg, id_anggota, id_peminjaman, tgl_kembali) VALUES ($id_brg, $id_anggota, $id_peminjaman, NOW())";

        $mysqli->query($barangQuery);
        $mysqli->query($peminjamanQuery);
        $mysqli->query($pengembalianQuery);

        echo "<script>alert('Data berhasil disetujui.'); window.location='peminjaman.php';</script>";
        exit();
    } elseif ($aksi_pengajuan === "Ditolak") {
        $peminjamanQuery = "UPDATE peminjaman SET aksi_pengajuan = '$aksi_pengajuan', status_pengajuan = '$status_pengajuan' WHERE id_peminjaman = $id_peminjaman";

        $mysqli->query($peminjamanQuery);

        echo "<script>alert('Data ditolak.'); window.location='peminjaman.php';</script>";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
