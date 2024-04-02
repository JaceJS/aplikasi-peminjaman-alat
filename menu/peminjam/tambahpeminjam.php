<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:index.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Anggota Peminjam</title>

  <link href="../../bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../bootstrap/dashboard.min.css" rel="stylesheet">
  <link href="../../bootstrap/bootstrap-v5.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once "../../templates/sidebar.php" ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php require_once "../../templates/header.php" ?>

        <div class="container-fluid px-5 text-gray-800" style="min-height: 100vh">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center mb-4">
            <h1 class="h3 mb-4">Tambah Anggota Peminjam</h1>
          </div>

          <form action="prosestambahpeminjam.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan nama" required autofocus>
            </div>
            <div class="mb-4">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="mb-4">
              <label for="divisi" class="form-label">Divisi</label>
              <br>
              <select name="divisi" id="divisi" class="form-select" aria-label="Default select example" required>
                <option selected value="">Pilih Divisi</option>
                <option value="Divisi Kerja Program">Divisi Kerja Program</option>
                <option value="Divisi Kerja Media Baru">Divisi Kerja Media Baru</option>
                <option value="Divisi Kerja Berita">Divisi Kerja Berita</option>
                <option value="Divisi Kerja Teknik">Divisi Kerja Teknik</option>
                <option value="Divisi Kerja Umum">Divisi Kerja Umum</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="phone" class="form-label">Nomor Telepon</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon" required>
              <p class="text-xs mt-2">(Terdiri dari 10 - 15 Angka)</p>
            </div>
            <div class="d-flex">
              <button type="submit" class="btn btn-success mt-3 mr-3">Tambah</button>
              <a href="peminjam.php">
                <button type="button" class="btn btn-danger mt-3">Kembali</button>
              </a>
            </div>
          </form>

        </div>

        <?php require_once "../../templates/footer.php" ?>
        <!-- End of Footer -->
      </div>
    </div>
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../../bootstrap/jquery/jquery.min.js"></script>
  <script src="../../bootstrap/bootstrap.bundle.min.js"></script>
  <script src="../../bootstrap/dashboard.min.js"></script>
</body>