<?php
session_start();
require_once("config/koneksi.php");

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    $_SESSION['validation_error'] = '<div class="alert alert-danger" role="alert">Semua kolom harus diisi</div>';
    header("Location: index.php");
    exit();
}

// Gunakan prepared statement untuk mencegah SQL injection
$stmt = $mysqli->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($id, $username, $hashed_password, $role);	

if ($stmt->fetch() && password_verify($password, $hashed_password)) {
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;

	if ($role == 'admin') {
        header("Location: dashboard.php");
    } elseif ($role == 'anggota') {
        header("Location: home.php");
    }
	
} else {	
	$_SESSION['login_error'] = '<div class="alert alert-danger" style="font-size: 1rem" role="alert">Username atau password tidak valid</div>';
	header("Location: index.php");
	exit();
}

$stmt->free_result();
$stmt->close();
$mysqli->close();
