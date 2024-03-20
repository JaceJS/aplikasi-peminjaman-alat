<?php
session_start();

require_once("config/koneksi.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$id_user = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#000">

    <title>Peminjaman Alat</title>

    <link href="bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="bootstrap/bootstrap-v5.min.css" rel="stylesheet">
</head>

<body style="min-height: 100vh; background: linear-gradient(to bottom right, #4a90e2, #6fa4e7, #8cb9ec, #a8cfe1, #c5e5e6);">
    <?php include 'templates/homenavbar.php'; ?>

    <h2 class="text-center mb-5 fw-bold">Daftar Alat</h2>

    <div class="container">
        <div class="row">
            <?php
            // Kode sql untuk menghitung total stok dan mendapatkan daftar jenis alat
            $sql = "SELECT barang.foto, jenis_barang.id_jenis,jenis_barang.nama AS nama_jenis, SUM(barang.stok_brg) AS total_stok
            FROM jenis_barang
            LEFT JOIN barang ON jenis_barang.id_jenis = barang.jenis_brg
            GROUP BY jenis_barang.id_jenis";

            $result = mysqli_query($mysqli, $sql);

            // Memeriksa apakah query berhasil dieksekusi
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="mb-4">
                            <div class="card mx-auto" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title text-center"><?php echo $row['nama_jenis']; ?></h5>
                                    <img src="images/barang/<?php echo $row['foto']; ?>" width="200px" height="200px" class="card-img-top" alt="foto_barang">
                                    <p class="card-text">Stok: <?php echo $row['total_stok']; ?></p>
                                    <div class="d-flex justify-content-between">
                                        <a href="homedetail.php?id_jenis=<?php echo $row['id_jenis']; ?>" class="btn btn-primary">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
                // Membebaskan hasil query
                mysqli_free_result($result);
            } else {
                // Jika query gagal dieksekusi, menampilkan pesan kesalahan
                echo "Error: " . mysqli_error($mysqli);
            }
            ?>
        </div>
    </div>

    <script src="bootstrap/bootstrap-v5.bundle.min.js"></script>
    <script src="bootstrap/jquery/jquery.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>

</body>

</html>