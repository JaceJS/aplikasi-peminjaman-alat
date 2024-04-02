<?php
$host = "localhost";
$username = "root";
$password = "root";
$db = "peminjaman_db";

$mysqli = new mysqli($host, $username, $password, $db);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");
