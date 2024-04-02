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

$query = "SELECT peminjaman.*, pengembalian.tgl_kembali
        FROM peminjaman
        LEFT JOIN pengembalian ON peminjaman.id_peminjaman = pengembalian.id_peminjaman
        WHERE peminjaman.id_anggota = $id_user
        ORDER BY peminjaman.tgl_pinjam 
        DESC";

$result = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000">
    <title>Riwayat Peminjaman</title>

    <link href="bootstrap/bootstrap-v5.min.css" rel="stylesheet">
    <link href="bootstrap/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="bootstrap/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body style="min-height: 100vh; background: linear-gradient(to bottom right, #4a90e2, #6fa4e7, #8cb9ec, #a8cfe1, #c5e5e6);">
    <?php include 'templates/homenavbar.php'; ?>

    <div class="container mt-5 bg-white shadow p-5 rounded">
        <h2 class="text-center mb-5 fw-bold">Riwayat Peminjaman</h2>
        <?php
        if ($result && $result->num_rows > 0) {
        ?>
            <div class="table-responsive">
                <table class="table table-bordered table-info table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th class="bg-primary text-light" scope="col">No</th>
                            <th class="bg-primary text-light" scope="col">Nama Peminjam</th>
                            <th class="bg-primary text-light" scope="col">Kode Alat</th>
                            <th class="bg-primary text-light" style="min-width: 100px" scope="col">Nama Alat</th>
                            <!-- <th class="bg-primary text-light" scope="col">Kuantitas</th> -->
                            <th class="bg-primary text-light" style="min-width: 170px" scope="col">Tanggal Pinjam</th>
                            <th class="bg-primary text-light" style="min-width: 170px" scope="col">Tanggal Kembali</th>
                            <!-- <th class="bg-primary text-light" scope="col">Catatan</th> -->
                            <th class="bg-primary text-light" scope="col">Status Peminjaman</th>
                            <th class="bg-primary text-light" scope="col">Status Pengembalian</th>
                            <th class="bg-primary text-light" scope="col">Aksi</th>
                            <th class="bg-primary text-light" scope="col">Status Pengajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td>
                                    <?php
                                    $id_anggota = $row['id_anggota'];
                                    $resultAnggota = $mysqli->query("SELECT nama FROM anggota WHERE id_anggota = $id_anggota");
                                    $anggota = $resultAnggota->fetch_assoc();
                                    echo $anggota['nama'];
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    $id_barang = $row['id_brg'];
                                    $resultBarang = $mysqli->query("SELECT nama_brg, kode FROM barang WHERE id_brg = $id_barang");
                                    $barang = $resultBarang->fetch_assoc();
                                    echo $barang['kode'];
                                    ?>
                                </td>

                                <td>
                                    <?php echo $barang['nama_brg']; ?>
                                </td>

                                <!-- <td><?php echo $row['kuantitas']; ?></td> -->

                                <td>
                                    <?php
                                    // Mendapatkan nilai tgl_pinjam dari database
                                    $tgl_pinjam = $row['tgl_pinjam'];

                                    if (!empty($tgl_pinjam)) {

                                        // Mengonversi nilai datetime ke format 12 jam (AM/PM)
                                        $tgl_pinjam_formatted = date('Y-M-d h:i A', strtotime($tgl_pinjam));

                                        // Menampilkan nilai yang telah diformat
                                        echo $tgl_pinjam_formatted;
                                    } else {
                                        echo "";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    // Mendapatkan nilai tgl_kembali dari database
                                    $tgl_kembali = $row['tgl_kembali'];

                                    // Cek apakah nilai kosong atau tidak
                                    if (!empty($tgl_kembali)) {
                                        // Mengonversi nilai datetime ke format 12 jam (AM/PM)
                                        $tgl_kembali_formatted = date('Y-M-d h:i A', strtotime($tgl_kembali));

                                        // Menampilkan nilai yang telah diformat
                                        echo $tgl_kembali_formatted;
                                    } else {
                                        // Jika nilai kosong, tampilkan pesan kosong
                                        echo "";
                                    }
                                    ?>
                                </td>

                                <!-- <td><?php echo $row['catatan']; ?></td> -->
                                <td>
                                    <?php if ($row['status_peminjaman'] == 0) { ?>
                                        <span class="btn btn-sm btn-info disabled">Booking</span>
                                    <?php } else if ($row['status_peminjaman'] == 1) { ?>
                                        <span class="btn btn-sm btn-success disabled">Disetujui</span>
                                    <?php } else if ($row['status_peminjaman'] == 2) { ?>
                                        <span class="btn btn-sm btn-danger disabled">Ditolak</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <span class="btn btn-sm disabled btn-<?php echo ($row['status'] == 1 ? 'success' : 'danger'); ?>">
                                        <?php echo $row['status'] == 1 ? '<small>Sudah Dikembalikan</small>' : '<small>Belum Dikembalikan</small>'; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php
                                    if ($row['status'] == 1 || $row['status_pengajuan'] == 'Diajukan') {
                                        echo '<button type="button" class="btn btn-sm btn-secondary" disabled>Ajukan Pengembalian</button>';
                                    } else if ($row['status_peminjaman'] == 1) {
                                    ?>
                                        <form method="post" action="prosesajukanpengembalian.php">
                                            <input type="hidden" name="id_peminjaman" value="<?php echo $row['id_peminjaman']; ?>">
                                            <input type="hidden" name="kuantitas" value="<?php echo $row['kuantitas']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success">Ajukan Pengembalian</button>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    if ($row['status_pengajuan'] == 'Diajukan') {
                                        echo '<span class="btn btn-sm disabled btn-info"><small>Diajukan</small></span>';
                                    } else if ($row['status_pengajuan'] == 'Disetujui') {
                                        echo '<span class="btn btn-sm disabled btn-success"><small>Disetujui</small></span>';
                                    } else if ($row['status_pengajuan'] == 'Ditolak') {
                                        echo '<span class="btn btn-sm disabled btn-danger"><small>Ditolak</small></span>';
                                    } else {
                                        echo '<span class="btn btn-sm disabled btn-secondary"><small>Belum Diajukan</small></span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        } else {
            echo "<h2 class='text-center text-success'>Belum ada riwayat peminjaman</h2>";
        }
        ?>
    </div>

    <script src="bootstrap/bootstrap-v5.bundle.min.js"></script>
    <script src="bootstrap/jquery/jquery.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="bootstrap/datatables/jquery.dataTables.min.js"></script>
    <script src="bootstrap/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="bootstrap/datatables/datatables-demo.js"></script>
</body>

</html>