<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_akun = $_GET['id_akun'];    ; 
    $username = htmlspecialchars($_POST['username']); 
    $password = htmlspecialchars($_POST['password']); 
    $role = htmlspecialchars($_POST['role']); 

    if (empty($username)) {
        echo "<script>alert('Username tidak boleh kosong.')</script>";
        exit();
    }    
    if (empty($password)) {
        echo "<script>alert('Password tidak boleh kosong.')</script>";
        exit();
    }    
    if (empty($role)) {
        echo "<script>alert('Role tidak boleh kosong.')</script>";
        exit();
    }    
    if ($role !== 'admin' && $role !== 'user') {
        echo "<script>alert('Role harus berupa admin atau user.')</script>";
        exit();
    }
    
    $query = "UPDATE users SET username='$username', password='$password', role='$role' WHERE id='$id_akun'";
    
    if ($mysqli->query($query)) {        
        echo "<script>alert('Akun berhasil diupdate.'); window.location='akun.php';</script>";            
        exit();
    } else {        
        echo "<script>alert('Gagal melakukan proses edit akun: " . $mysqli->error . "')</script>";
        exit();
    }

} else {
    header("location: akun.php");
    exit();
}