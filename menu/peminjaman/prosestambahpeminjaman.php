<?php
include '../../config/koneksi.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_brg = $_POST['barang'];
    $id_anggota = $_POST['peminjam'];
    $tgl_booking = $_POST['tgl_booking'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $kuantitas = 1;
    // $kuantitas = $_POST['kuantitas'];
    // $catatan = $_POST['catatan'];

    $today = date("Y-m-d");
    // if ($tgl_pinjam > $today) {
    //     echo "<script>alert('Tanggal pinjam tidak boleh melebihi hari ini.'); window.location='tambahpeminjaman.php';</script>";
    //     exit();
    // }

    $mysqli->autocommit(FALSE);

    $insertPeminjaman = $mysqli->prepare("INSERT INTO peminjaman (id_brg, id_anggota, tgl_booking, tgl_pinjam, kuantitas, status_peminjaman, status) VALUES (?, ?, ?, ?, ?, 1, 0)");
    $updateStokBarang = $mysqli->prepare("UPDATE barang SET stok_brg = stok_brg - ? WHERE id_brg = ?");

    if ($insertPeminjaman && $updateStokBarang) {
        $insertPeminjaman->bind_param("iissi", $id_brg, $id_anggota, $tgl_booking, $tgl_pinjam, $kuantitas);
        $updateStokBarang->bind_param("ii", $kuantitas, $id_brg);

        $insertPeminjaman->execute();
        $updateStokBarang->execute();

        $insertPeminjaman->close();
        $updateStokBarang->close();

        $mysqli->commit();

        echo "<script>alert('Data berhasil ditambahkan.'); window.location.href='peminjaman.php';</script>";
        exit();
    } else {
        $mysqli->rollback();
        echo "<script>alert('Error: " . $mysqli->error . "'); window.location.href='tambahpeminjaman.php';</script>";
    }
    $mysqli->autocommit(TRUE);
    $mysqli->close();
}
