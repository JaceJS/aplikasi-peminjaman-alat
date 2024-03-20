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

  <title>Peminjaman</title>

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
            <h1 class="h3 mb-4">Edit Peminjaman</h1>
          </div>

          <?php
          $id_peminjaman = $_GET['id_peminjaman'];
          $query = $mysqli->query("SELECT * FROM peminjaman INNER JOIN anggota ON peminjaman.id_anggota=anggota.id_anggota where id_peminjaman='$id_peminjaman'");                    
          $lihat = mysqli_fetch_array($query)
          ?>

          <form action="proseseditpeminjaman.php?id_peminjaman=<?php echo $lihat['id_peminjaman'];?>" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="barang" class="form-label">Alat</label>
                <br>                                 
                <select name="barang" id="barang" class="form-select" aria-label="Default select example" required>                    
                    <?php
                    $query = $mysqli->query("SELECT * from barang");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <option value="
                      <?php echo $data['id_brg']?>" 
                      <?php echo $data['id_brg'] == $lihat['id_brg'] ? 'selected'  : ' ' ?>
                      ><?php echo $data['nama_brg'];?> 
                    </option>
                    <?php 
                    } 
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="peminjam" class="form-label">Nama Peminjam</label>
                <br>                                 
                <select name="peminjam" id="peminjam" class="form-select" aria-label="Default select example" required>                    
                    <?php                    
                    $query = $mysqli->query("SELECT * from anggota");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <option value="
                      <?php echo $data['id_anggota']?>" 
                      <?php echo $data['id_anggota'] == $lihat['id_anggota'] ? 'selected'  : ' ' ?>
                      ><?php echo $data['nama'];?>
                    </option>
                    <?php 
                    } 
                    ?>
                </select>
            </div>
            <div class="mb-4" style="max-width: 180px">
              <label for="tgl_pinjam" class="form-label">Tanggal Peminjaman</label>                                      
              <input type="datetime-local" name="tgl_pinjam" id="tgl_pinjam" class="form-control" value="<?php echo $lihat['tgl_pinjam']?>" required>                           
            </div>
            <div class="mb-4">
                <label for="status" class="form-label">Status Peminjaman</label>
                <br>
                <select name="status" id="status" class="form-select" aria-label="Default select example" required>
                    <option disabled value="0" <?php echo $lihat['status'] == 0 ? 'selected' : ' ' ?>>Belum Dikembalikan</option>
                    <option value="1" <?php echo $lihat['status'] == 1 ? 'selected' : ' ' ?>>Sudah Dikembalikan</option>
                </select>
            </div>

            <div class="mb-4">
              <label for="catatan" class="form-label">Catatan</label>
              <textarea class="form-control" id="catatan" name="catatan" rows="4" required><?php echo htmlspecialchars($lihat['catatan']); ?></textarea>
            </div>

            <div class="d-flex">
              <button type="submit" class="btn btn-success mt-3 mr-3">Simpan</button>
              <a href="peminjaman.php">
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