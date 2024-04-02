<?php
require_once "config/koneksi.php";

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

  <title>Dashboard</title>

  <link href="bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="bootstrap/dashboard.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once "templates/sidebar.php" ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once "templates/header.php" ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid" style="min-height: 100vh">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            <?php
            $query_total_stok = $mysqli->query("SELECT SUM(stok_brg) as a FROM barang");
            $data_total_stok = mysqli_fetch_assoc($query_total_stok);

            $query_data_dipinjam = $mysqli->query("SELECT count(status) as a FROM peminjaman WHERE status = 0 AND status_peminjaman = 1");
            $data_dipinjam = mysqli_fetch_assoc($query_data_dipinjam);

            $query_data_jenis_barang = $mysqli->query("SELECT jenis_barang.*, COUNT(barang.id_brg) AS jumlah_barang
            FROM jenis_barang
            INNER JOIN barang ON barang.jenis_brg = jenis_barang.id_jenis
            GROUP BY jenis_barang.nama, jenis_barang.foto, jenis_barang.id_jenis");
            // $data_jenis_barang = mysqli_fetch_assoc($query_data_jenis_barang);
            ?>
            <!-- Card -->
            <div class="col-xl-6 col-md-6 mb-4">
              <a href="menu/alat/alat.php" style="text-decoration: none; color: inherit;">
                <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xl font-weight-bold text-success text-uppercase mb-3">
                          Total Stok Tersedia
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data_total_stok['a']; ?> Alat</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Card -->
            <div class="col-xl-6 col-md-6 mb-4">
              <a href="menu/peminjaman/peminjaman.php" style="text-decoration: none; color: inherit;">
                <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xl font-weight-bold text-warning text-uppercase mb-3">
                          Alat yang Sedang Dipinjam
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $data_dipinjam['a']; ?> Alat</div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-warning"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="row">
            <?php
            while ($data_jenis_barang = mysqli_fetch_assoc($query_data_jenis_barang)) {
            ?>
              <a href="menu/alat/alat.php">
                <div class="col-md-6 col-lg-4">
                  <div class="mb-4">
                    <div class="card mx-auto" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title text-center fw-bold"><?php echo $data_jenis_barang['nama']; ?></h5>
                        <img src="images/jenis_barang/<?php echo $data_jenis_barang['foto']; ?>" width="200px" height="200px" class="card-img-top" alt="foto_barang">
                        <h4 class="card-text text-dark">Jumlah Alat: <?php echo $data_jenis_barang['jumlah_barang']; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            <?php
            }
            ?>
          </div>
        </div>

        <!-- Footer -->
        <?php require_once "templates/footer.php" ?>
        <!-- End of Footer -->

      </div>

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <script src="bootstrap/jquery/jquery.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <script src="bootstrap/dashboard.min.js"></script>
</body>