<?php
include 'config/koneksi.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('location:index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_POST['id_user'];
    $id_barang_array = $_POST['id_brg'];
    $quantitas_array = $_POST['quantity'];
    $tgl_booking = date('Y-m-d H:i:s');
    $tgl_pinjam = $_POST['tgl_pinjam'];

    $mysqli->autocommit(FALSE);

    $insertPeminjaman = $mysqli->prepare("INSERT INTO peminjaman (id_brg, id_anggota, tgl_booking, tgl_pinjam, kuantitas, status_peminjaman, status) VALUES (?, ?, NOW(), ?, ?, 0, 0)");

    if ($insertPeminjaman) {
        $insertPeminjaman->bind_param("iisi", $id_barang, $id_user, $tgl_pinjam, $quantity);

        // Melakukan pengulangan melalui array ID barang dan jumlah barang
        for ($i = 0; $i < count($id_barang_array); $i++) {
            $id_barang = $id_barang_array[$i];
            $quantity = $quantitas_array[$i];

            // Mengambil detail barang dari database berdasarkan ID barang
            $sql = mysqli_query($mysqli, "SELECT stok_brg, nama_brg FROM barang WHERE id_brg = $id_barang");
            $data_brg = mysqli_fetch_assoc($sql);
            $stok_brg = $data_brg['stok_brg'];
            $nama_brg = $data_brg['nama_brg'];

            // Memeriksa apakah jumlah yang diminta melebihi stok yang tersedia
            if ($quantity > $stok_brg) {
                echo "<script>alert('Stok tidak mencukupi. Sisa stok $nama_brg yaitu $stok_brg'); window.location='daftarpinjam.php';</script>";
                exit();
            }

            // Jika jumlah yang diminta dalam batas stok yang tersedia, lanjutkan eksekusi peminjaman
            $insertPeminjaman->execute();
        }

        $insertPeminjaman->close();

        $mysqli->commit();

        unset($_SESSION['cart']);
        echo "<script>alert('Alat berhasil dibooking.'); window.location='riwayatpeminjaman.php';</script>";
        exit();
    } else {
        $mysqli->rollback();
        echo "Error: " . $mysqli->error;
    }

    $mysqli->autocommit(TRUE);
} else {
    header('Location: index.php');
    exit();
}
