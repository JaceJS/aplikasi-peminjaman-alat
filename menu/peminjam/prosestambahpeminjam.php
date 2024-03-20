<?php
include '../../config/koneksi.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $divisi = $_POST["divisi"];   
    $kontak = $_POST["phone"];

    if (!preg_match("/^[0-9]{10,15}$/", $kontak)) {
        echo "<script>alert('Nomor telepon tidak valid.'); window.location.href='tambahpeminjam.php';</script>";
        exit();
    }
    
    $query = "INSERT INTO anggota (nama, divisi, kontak) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $divisi, $kontak);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Data berhasil ditambahkan.'); window.location.href='peminjam.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data.'); window.location.href='tambahpeminjam.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error: " . $mysqli->error . "'); window.location.href='tambahpeminjam.php';</script>";
    }

    $mysqli->close();
}
?>
