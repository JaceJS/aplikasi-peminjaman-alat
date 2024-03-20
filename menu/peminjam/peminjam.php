<?php
include "../../config/koneksi.php";
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('location:../../index.php');
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
  <link href="../../bootstrap/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
        <!-- End of Topbar -->

        <div class="container-fluid" style="min-height: 100vh">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Anggota Peminjam</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3 d-flex justify-content-end">
                <a href="tambahpeminjam.php" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
              </div>
            </div>
          </div>

          <div class="card shadow mb-4">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Divisi</th>
                      <th>Nomor Telepon</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = $mysqli->query("SELECT * FROM anggota");
                    $no = 1;
                    while ($lihat = mysqli_fetch_array($query)) {
                    ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $lihat['nama'];?></td>
                        <td><?php echo $lihat['divisi'];?></td>                        
                        <td><?php echo $lihat['kontak'];?></td>                        
                        <td>
                          <form action="hapuspeminjam.php?id_peminjam=<?php echo $lihat['id_anggota']; ?>" onsubmit="return confirm('Yakin ingin hapus <?php echo $lihat['nama']; ?>?');" method="POST">
                            <a href="editpeminjam.php?id_peminjam=<?php echo $lihat['id_anggota']; ?>" class="btn btn-warning">Edit</a>
                            <button type="submit" class="btn btn-danger">Hapus</button>                            
                          </form>                                                    
                        </td>
                      </tr>
                    <?php
                    } ?>
                </table>

              </div>
            </div>
          </div>

        </div>

        <!-- Footer -->
        <?php require_once "../../templates/footer.php" ?>
        <!-- End of Footer -->

      </div>

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    
    <script src="../../bootstrap/jquery/jquery.min.js"></script>
    <script src="../../bootstrap/bootstrap.bundle.min.js"></script>  
    <script src="../../bootstrap/dashboard.min.js"></script>
    <!-- DataTables -->
    <script src="../../bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script src="../../bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="../../bootstrap/datatables/datatables-demo.js"></script>
</body>