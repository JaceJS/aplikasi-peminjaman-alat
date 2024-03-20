<?php
include '../../config/koneksi.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Cek apakah username sudah ada di database
    $stmt_check_username = $mysqli->prepare("SELECT username FROM users WHERE username = ?");
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $stmt_check_username->store_result();

    if ($stmt_check_username->num_rows > 0) {        
        echo "<script>alert('Username sudah digunakan. Pilih username lain.'); window.location.href='tambahakun.php';</script>";        
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $hashed_password, $role);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Data berhasil ditambahkan.'); window.location.href='akun.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan data.'); window.location.href='tambahakun.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error: " . $mysqli->error . "'); window.location.href='tambahakun.php';</script>";
    }
} else {
    echo "<script>alert('Error: " . $mysqli->error . "'); window.location.href='tambahakun.php';</script>";
}