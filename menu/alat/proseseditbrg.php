<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_brg = $_GET['id_brg'];
    $nama_brg = htmlspecialchars($_POST['nama_brg']);
    $jenis_brg = htmlspecialchars($_POST['jenis_brg']);
    $kode = htmlspecialchars($_POST['kode']);
    // $stok_brg = intval($_POST['stok_brg']);
    $foto_brg = $_FILES['foto_brg']['name'];

    if (empty($nama_brg)) {
        echo "<script>alert('Nama barang tidak boleh kosong.')</script>";
        exit();
    }
    // if (!is_int($stok_brg) || $stok_brg < 0) {
    //     echo "<script>alert('Stok barang harus berupa bilangan bulat non-negatif.')</script>";
    //     exit();
    // }

    if (!empty($foto_brg)) {
        $tmp_foto = $_FILES['foto_brg']['tmp_name'];
        $size_foto = $_FILES['foto_brg']['size'];
        $foto_brg_destination = "../../images/barang/" . $foto_brg;

        if ($size_foto > 2 * 1024 * 1024) {
            echo "<script>alert('Ukuran file gambar terlalu besar. Maksimal 2 MB.')</script>";
            exit();
        }

        if (move_uploaded_file($tmp_foto, $foto_brg_destination)) {
            // Mendapatkan nama gambar lama
            $query_get_old_image = "SELECT foto FROM barang WHERE id_brg='$id_brg'";
            $result_get_old_image = $mysqli->query($query_get_old_image);
            $row_old_image = $result_get_old_image->fetch_assoc();
            $old_image_path = "../../images/barang/" . $row_old_image['foto'];

            // Hapus gambar lama jika ada
            if (file_exists($old_image_path)) {
                unlink($old_image_path);
            }
            $query = "UPDATE barang SET nama_brg='$nama_brg', jenis_brg='$jenis_brg', kode='$kode', foto='$foto_brg' WHERE id_brg='$id_brg'";
        } else {
            echo "<script>alert('Gagal mengunggah file gambar.')</script>";
            exit();
        }
    } else {
        $query = "UPDATE barang SET nama_brg='$nama_brg', jenis_brg='$jenis_brg', kode='$kode' WHERE id_brg='$id_brg'";
    }

    if ($mysqli->query($query)) {
        echo "<script>alert('Barang berhasil diupdate.'); window.location='alat.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal melakukan proses edit barang: " . $mysqli->error . "')</script>";
        exit();
    }
} else {
    header("location: alat.php");
    exit();
}
