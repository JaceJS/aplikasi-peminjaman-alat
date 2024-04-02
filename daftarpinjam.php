<?php
session_start();

require_once("config/koneksi.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'anggota') {
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000">
    <title>Daftar Pinjam</title>

    <link href="bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="bootstrap/bootstrap-v5.min.css" rel="stylesheet">
</head>

<body style="min-height: 100vh; background: linear-gradient(to bottom right, #4a90e2, #6fa4e7, #8cb9ec, #a8cfe1, #c5e5e6);">
    <?php include 'templates/homenavbar.php'; ?>

    <div class="container mt-5 bg-light shadow p-5 rounded">
        <h2 class="text-center mb-5 fw-bold">Daftar Pinjam</h2>
        <?php
        if (!empty($_SESSION['cart'])) {
        ?>
            <form action="prosespinjamalat.php" method="POST">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="bg-primary text-white" scope="col">No</th>
                                <th class="bg-primary text-white" scope="col">Kode Alat</th>
                                <th class="bg-primary text-white" scope="col">Nama Alat</th>
                                <!-- <th class="bg-primary text-white" scope="col">Kuantitas</th> -->
                                <th class="bg-primary text-white" scope="col">Tanggal Pengambilan</th>
                                <th class="bg-primary text-white" scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $counter = 1;
                            foreach ($_SESSION['cart'] as $session_item) {
                                $id_brg = $session_item['id_brg'];
                                $result = $mysqli->query("SELECT stok_brg FROM barang WHERE id_brg = $id_brg");

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    $stok_brg = $row['stok_brg'];

                                    $max_quantity = $stok_brg;
                                } else {
                                    echo "Error: " . $mysqli->error;
                                    $max_quantity = 1;
                                }
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $counter++; ?></th>
                                    <td><?php echo $session_item['kode']; ?></td>
                                    <td><?php echo $session_item['nama_brg']; ?></td>
                                    <td class="input-group d-none">
                                        <div class="d-flex align-items-center">
                                            <input type="hidden" name="id_brg[]" value="<?php echo $session_item['id_brg']; ?>">
                                            <input class="form-control" style="min-width:100px; border-radius: 4px 0 0 4px;" type="number" id="quantity_<?php echo $session_item['id_brg']; ?>" name="quantity[]" value="<?php echo $session_item['kuantitas']; ?>" min="1" max="<?php echo $max_quantity; ?>" readonly>
                                            <button class="btn btn-outline-danger" style="border-radius: 0;" type="button" onclick="decrementQuantity('<?php echo $session_item['id_brg']; ?>')">-</button>
                                            <button class="btn btn-outline-primary" style="border-radius: 0 4px 4px 0;" type="button" onclick="incrementQuantity('<?php echo $session_item['id_brg']; ?>')">+</button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="mb-4" style="max-width: 180px">
                                            <input type="datetime-local" name="tgl_pinjam" id="tgl_pinjam" class="form-control" required>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="hapuscart.php?id_brg=<?php echo $session_item['id_brg']; ?>" class="btn btn-danger" onclick="removeItem(<?php echo $session_item['id_brg']; ?>)">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="id_user" value=<?php echo $id_user; ?>>
                <div class="text-center">
                    <button type="submit" class="btn btn-success btn-lg mt-4">Booking Peminjaman</button>
                </div>
            </form>
        <?php
        } else {
            echo "<h2 class='text-center text-success'>Daftar kosong</h2>";
        }
        ?>
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
    <script>
        function removeItem(id_brg) {
            $.ajax({
                type: "GET",
                url: "hapuscart.php?id_brg=" + id_brg,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        window.location.href = "daftarpinjam.php";
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan, silahkan coba lagi nanti.");
                }
            });
        }
    </script>
</body>

</html>