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

  <title>Pengembalian</title>

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
            <h1 class="h3 mb-4 text-gray-800">Pengembalian</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3 d-flex justify-content-between">
                <a href="download_pengembalian_pdf.php" target="_blank" class="btn btn-primary">Download Data (PDF)</a>
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
                      <th>Nama Alat</th>
                      <th>Nama Peminjam</th>
                      <th>Tanggal Pinjam</th>
                      <th>Tanggal Kembali</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT pengembalian.*,
                              barang.id_brg,
                              barang.nama_brg,
                              peminjaman.id_peminjaman,
                              peminjaman.tgl_pinjam,
                              peminjaman.status,
                              anggota.id_anggota,
                              anggota.nama
                              FROM pengembalian 
                              JOIN barang ON pengembalian.id_brg=barang.id_brg 
                              JOIN anggota ON pengembalian.id_anggota=anggota.id_anggota 
                              JOIN peminjaman ON peminjaman.id_peminjaman=pengembalian.id_peminjaman 
                              WHERE peminjaman.status=1
                              ORDER BY pengembalian.tgl_kembali DESC";
                    $query = $mysqli->query($sql);
                    $no = 1;
                    while ($lihat = mysqli_fetch_array($query)) {
                    ?>
                      <tr>
                        <td>
                          <?php echo $no++; ?></td>
                        <td><?php echo $lihat['nama_brg']; ?></td>
                        <td><?php echo $lihat['nama']; ?></td>
                        <td><?php
                            // Mendapatkan nilai tgl_pinjam dari database
                            $tgl_pinjam = $lihat['tgl_pinjam'];

                            if (!empty($tgl_pinjam)) {

                              // Mengonversi nilai datetime ke format 12 jam (AM/PM)
                              $tgl_pinjam_formatted = date('d-M-Y h:i A', strtotime($tgl_pinjam));

                              // Menampilkan nilai yang telah diformat
                              echo $tgl_pinjam_formatted;
                            } else {
                              echo "";
                            }
                            ?></td>
                        <td>
                          <?php
                          // Mendapatkan nilai tgl_pinjam dari database
                          $tgl_kembali = $lihat['tgl_kembali'];

                          if (!empty($tgl_kembali)) {

                            // Mengonversi nilai datetime ke format 12 jam (AM/PM)
                            $tgl_kembali_formatted = date('d-M-Y h:i A', strtotime($tgl_kembali));

                            // Menampilkan nilai yang telah diformat
                            echo $tgl_kembali_formatted;
                          } else {
                            echo "";
                          }
                          ?>
                        </td>
                        <td>
                          <form action="hapuspengembalian.php?id_pengembalian=<?php echo $lihat['id_pengembalian']; ?>" onsubmit="return confirm('Yakin ingin hapus <?php echo $lihat['nama_brg']; ?>?');" method="POST">
                            <a href="editpengembalian.php?id_pengembalian=<?php echo $lihat['id_pengembalian']; ?>" class="btn btn-warning">Edit</a>
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