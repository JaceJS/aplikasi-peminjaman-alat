<?php
session_start();
include("config/koneksi.php");


if (isset($_POST['add_to_cart'])) {
    $id_brg = $_POST['id_brg'];
    $id_anggota = $_POST['id_anggota'];
    $kuantitas = $_POST['kuantitas'];

    $sql = $mysqli->query("SELECT stok_brg FROM barang WHERE id_brg = $id_brg");
    $stok_brg = mysqli_fetch_array($sql);

    // Jika barang sudah ada di session, tambahkan kuantitasnya saja
    if (isset($_SESSION['cart'][$id_brg])) {
        if ($_SESSION['cart'][$id_brg]['kuantitas'] + $kuantitas > $stok_brg['stok_brg']) {
            echo "<script>alert('Stok barang tidak mencukupi!');window.location='home.php';</script>";
            exit();
        }
        $_SESSION['cart'][$id_brg]['kuantitas'] += $kuantitas;
    }

    // Jika barang belum ada di session, tambahkan barangnya
    else {
        if ($kuantitas > $stok_brg['stok_brg']) {
            echo "<script>alert('Stok barang tidak mencukupi!');window.location='home.php';</script>";
            exit();
        }

        $sql = $mysqli->query("SELECT * FROM barang WHERE id_brg = $id_brg");
        $row_alat = mysqli_fetch_array($sql);

        $_SESSION['cart'][$id_brg] = array(
            'id_brg' => $row_alat['id_brg'],
            'nama_brg' => $row_alat['nama_brg'],
            'kode' => $row_alat['kode'],
            'kuantitas' => $kuantitas,
        );

        echo "<script>alert('Barang berhasil ditambahkan ke Daftar Pinjam!');window.location='home.php';</script>";
        exit();
    }
}
