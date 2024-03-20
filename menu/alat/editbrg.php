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

  <title>Alat</title>

  <link href="../../bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../../bootstrap/dashboard.min.css" rel="stylesheet">
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

        <div class="container-fluid px-5 text-dark" style="min-height: 100vh">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center mb-4">
            <h1 class="h3 mb-4">Edit Alat</h1>
          </div>

          <?php
          $id_brg = $_GET['id_brg'];
          $query = $mysqli->query("SELECT * FROM barang where id_brg='$id_brg'");
          while ($lihat = mysqli_fetch_array($query)) {
          ?>

            <form action="proseseditbrg.php?id_brg=<?php echo $lihat['id_brg'] ?>" method="post" enctype="multipart/form-data">
              <div class="mb-4">
                <label for="namaBarang" class="form-label">Nama Alat</label>
                <input type="text" class="form-control" id="namaBarang" name="nama_brg" value="<?php echo $lihat['nama_brg'] ?>" required autofocus>
              </div>
              <div class="mb-4">
                <label for="jenisBarang" class="form-label">Jenis Alat</label>
                <select class="form-control" id="jenisBarang" name="jenis_brg" required>

                  <?php
                  // Mengambil daftar nama jenis alat dari tabel jenis_barang
                  $sql = "SELECT * FROM jenis_barang";
                  $result = mysqli_query($mysqli, $sql);

                  // Memeriksa apakah query berhasil dieksekusi
                  if ($result) {
                    // Menampilkan setiap nama jenis alat sebagai pilihan dropdown
                    while ($row = mysqli_fetch_assoc($result)) {
                      $selected = ($row['id_jenis'] == $lihat['jenis_brg']) ? "selected" : "";
                      echo "<option value='" . $row['id_jenis'] . "' $selected>" . $row['nama'] . "</option>";
                    }
                    // Membebaskan hasil query
                    mysqli_free_result($result);
                  } else {
                    // Jika query gagal dieksekusi, menampilkan pesan kesalahan
                    echo "<option value=''>Error: Gagal mendapatkan data jenis alat</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="mb-4">
                <label for="stokBarang" class="form-label">Stok Alat</label>
                <input type="number" class="form-control" id="stokBarang" name="stok_brg" value="<?php echo $lihat['stok_brg'] ?>" required>
              </div>
              <div class="mb-4">
                <label for="kode" class="form-label">Kode Alat</label>
                <input type="text" class="form-control" id="kode" name="kode" value="<?php echo $lihat['kode'] ?>" required>
              </div>
              <div class="mb-4">
                <label for="fotoBarang" class="form-label">Foto Alat</label>
                <br>
                <input type="file" id="fotoBarang" name="foto_brg">
                <p class="text-xs mt-2">(Maksimal 2 MB)</p>
              </div>
              <div class="d-flex">
                <button type="submit" class="btn btn-success mt-3 mr-3">Simpan</button>
                <a href="alat.php">
                  <button type="button" class="btn btn-danger mt-3">Kembali</button>
                </a>
              </div>
            </form>

          <?php
          }
          ?>
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