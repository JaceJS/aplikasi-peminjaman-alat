<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Pastikan parameter id_brg ada dalam URL
if (isset($_GET['id_brg'])) {
    $id_brg_to_remove = $_GET['id_brg'];

    // Loop melalui item di keranjang
    foreach ($_SESSION['cart'] as $key => $item) {
        // Jika id_brg cocok, hapus item dari keranjang
        if ($item['id_brg'] == $id_brg_to_remove) {
            unset($_SESSION['cart'][$key]);

            // Set status dan pesan respons
            $response['status'] = 'success';
            $response['message'] = 'Alat berhasil dihapus.';

            break;
        }
    }
}
echo json_encode($response);
?>
