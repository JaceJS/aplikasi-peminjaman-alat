<?php
include '../../config/koneksi.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaBarang = $_POST["nama_brg"];
    $jenisBarang = $_POST["jenis_brg"];
    // $stokBarang = $_POST["stok_brg"];
    $kodeBarang = $_POST["kode"];

    $uploadDir = "../../images/barang/";
    $namaFotoBarang = null;

    if (!empty($_FILES["foto_brg"]["name"])) {
        $namaFotoBarang = $_FILES["foto_brg"]["name"];
        $fotoBarang = $uploadDir . basename($_FILES["foto_brg"]["name"]);

        $imageFileType = strtolower(pathinfo($fotoBarang, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["foto_brg"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File bukan gambar.'); window.location.href='tambahbrg.php';</script>";
            exit();
        }
        if ($_FILES["foto_brg"]["size"] > 2000000) {
            echo "<script>alert('Ukuran gambar terlalu besar.'); window.location.href='tambahbrg.php';</script>";
            exit();
        }
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "<script>alert('Format gambar tidak didukung.'); window.location.href='tambahbrg.php';</script>";
            exit();
        }
        move_uploaded_file($_FILES["foto_brg"]["tmp_name"], $fotoBarang);
    }

    $sql = "INSERT INTO barang (nama_brg, jenis_brg, stok_brg, kode, foto) VALUES (?, ?, 1, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("siss", $namaBarang, $jenisBarang, $kodeBarang, $namaFotoBarang);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Data berhasil ditambahkan.'); window.location.href='alat.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data.'); window.location.href='tambahbrg.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error: " . $mysqli->error . "'); window.location.href='tambahbarang.php';</script>";
    }

    $mysqli->close();
}
