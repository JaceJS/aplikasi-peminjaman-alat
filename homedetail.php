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
            $id_brg = $_GET['id_jenis'];
            
            $sql = $mysqli->query("SELECT * FROM barang 
            LEFT JOIN jenis_barang 
            ON barang.jenis_brg = jenis_barang.id_jenis 
            WHERE barang.jenis_brg = $id_brg");

            while ($row_alat = mysqli_fetch_array($sql)) {
                $foto = $row_alat['foto'];
            ?>
                <form class="col-md-6 col-lg-4" method="POST" action="prosestambahkecart.php">
                    <input type="hidden" name="id_brg" value="<?php echo $row_alat['id_brg']; ?>">
                    <input type="hidden" name="id_anggota" value="<?php echo $id_user; ?>">
                    <div class="mb-4">
                        <div class="card mx-auto" style="width: 18rem;">
                            <img src="images/barang/<?php echo $foto; ?>" width="200px" height="200px" class="card-img-top" alt="foto_barang">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row_alat['nama_brg']; ?></h5>
                                <p class="card-text">Stok: <?php echo $row_alat['stok_brg']; ?></p>
                                <?php if ($role == 'anggota') : ?>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Jumlah :</span>
                                        <input type="number" name="kuantitas" value="1" min="1" max="<?php echo $row_alat['stok_brg']; ?>" class="form-control bg-light" id="quantity_<?php echo $row_alat['id_brg']; ?>" readonly>
                                        <button class="btn btn-outline-danger" type="button" onclick="decrementQuantity('<?php echo $row_alat['id_brg']; ?>')">-</button>
                                        <button class="btn btn-outline-primary" type="button" onclick="incrementQuantity('<?php echo $row_alat['id_brg']; ?>')">+</button>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <button type="submit" name="add_to_cart" class="btn btn-success">Tambah</button>
                                        <a href="home.php" class="btn btn-danger">Kembali</a>                                       
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
    </div>

    <script src="bootstrap/bootstrap-v5.bundle.min.js"></script>
    <script src="bootstrap/jquery/jquery.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        function decrementQuantity(productId) {
            var quantityInput = document.getElementById('quantity_' + productId);
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        }

        function incrementQuantity(productId) {
            var quantityInput = document.getElementById('quantity_' + productId);
            if (parseInt(quantityInput.value) < parseInt(quantityInput.max)) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
            }

        }
    </script>

</body>

</html>