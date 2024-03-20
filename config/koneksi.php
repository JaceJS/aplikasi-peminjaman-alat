<?php
$host = "localhost:3307";
$username = "root";
$password = "";
$db = "pemin_alat";

$mysqli = new mysqli($host, $username, $password, $db);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$mysqli->set_charset("utf8");
