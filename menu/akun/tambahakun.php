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

  <title>akun</title>

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
            <h1 class="h3 mb-4">Tambah akun</h1>
          </div>

          <form action="prosestambahakun.php" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label" for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required />
            </div>
            <div class="mb-4">                                                        
                <label for="role" class="form-label">Role</label>
                <br>                                 
                <select name="role" id="role" class="form-select" aria-label="Default select example" required disabled>
                    <option value="admin">Admin</option>                 
                </select>
            </div>
            
            <div class="d-flex">
              <button type="submit" class="btn btn-success mt-3 mr-3">Tambah</button>
              <a href="akun.php">
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