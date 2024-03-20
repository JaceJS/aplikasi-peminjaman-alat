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

  <title>Peminjaman</title>

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
            <h1 class="h3 mb-3 text-gray-800">Peminjaman</h1>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3 d-flex justify-content-between">
                <a href="download_peminjaman_pdf.php" target="_blank" class="btn btn-primary">Download Data (PDF)</a>
                <a href="tambahpeminjaman.php" class="btn btn-success"><i class="fa fa-plus"></i> Tambah</a>
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
                      <th style="min-width: 170px">Tanggal Booking</th>
                      <th>Pengajuan Peminjaman</th>
                      <th>Status Peminjaman</th>
                      <th>Nama Alat</th>
                      <th>Nama Peminjam</th>
                      <th style="min-width: 170px">Tanggal Pinjam</th>
                      <th>Kuantitas</th>                      
                      <th>Catatan</th>
                      <th>Pengajuan Kembali</th>
                      <th>Status Pengembalian</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $sql = "SELECT peminjaman.*, barang.nama_brg, anggota.nama 
                            FROM peminjaman 
                            JOIN barang ON peminjaman.id_brg=barang.id_brg 
                            JOIN anggota ON anggota.id_anggota=peminjaman.id_anggota 
                            ORDER BY peminjaman.tgl_booking
                            DESC";
                    $query = $mysqli->query($sql);
                    $no = 1;
                    while ($lihat = mysqli_fetch_array($query)) {
                    ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td>
                          <?php
                          // Mendapatkan nilai tgl_pinjam dari database
                          $tgl_booking = $lihat['tgl_booking'];

                          // Mengonversi nilai datetime ke format 12 jam (AM/PM)
                          $tgl_booking_formatted = date('Y-M-d h:i A', strtotime($tgl_booking));

                          // Menampilkan nilai yang telah diformat
                          echo $tgl_booking_formatted;
                          ?>
                        </td>
                        <td class="d-flex flex-row">
                          <?php if ($lihat['status_peminjaman'] == 0) { ?>
                            <form method="post" action="prosesapprovepeminjaman.php" class="mr-2">
                              <input type="hidden" name="id_peminjaman" value="<?php echo $lihat['id_peminjaman']; ?>">
                              <input type="hidden" name="id_brg" value="<?php echo $lihat['id_brg']; ?>">
                              <input type="hidden" name="id_anggota" value="<?php echo $lihat['id_anggota']; ?>">
                              <input type="hidden" name="kuantitas" value="<?php echo $lihat['kuantitas']; ?>">
                              <input type="hidden" name="aksi_pengajuan" value="Disetujui">

                              <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                            <form method="post" action="prosesapprovepeminjaman.php">
                              <input type="hidden" name="id_peminjaman" value="<?php echo $lihat['id_peminjaman']; ?>">
                              <input type="hidden" name="id_brg" value="<?php echo $lihat['id_brg']; ?>">
                              <input type="hidden" name="id_anggota" value="<?php echo $lihat['id_anggota']; ?>">
                              <input type="hidden" name="kuantitas" value="<?php echo $lihat['kuantitas']; ?>">
                              <input type="hidden" name="aksi_pengajuan" value="Ditolak">

                              <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                          <?php } else if ($lihat['status_peminjaman'] == 1) { ?>
                            <span class="btn btn-sm btn-success disabled">Disetujui</span>
                          <?php } else if ($lihat['status_peminjaman'] == 2) { ?>
                            <span class="btn btn-sm btn-danger disabled">Ditolak</span>
                          <?php } ?>

                        </td>
                        <td>
                          <span class="btn btn-sm disabled btn-<?php
                                                                if ($lihat['status_peminjaman'] == 1) {
                                                                  echo 'success';
                                                                } elseif ($lihat['status_peminjaman'] == 2) {
                                                                  echo 'danger';
                                                                } else {
                                                                  echo 'info';
                                                                }
                                                                ?>">
                            <?php
                            if ($lihat['status_peminjaman'] == 1) {
                              echo '<small>Dipinjam</small>';
                            } elseif ($lihat['status_peminjaman'] == 2) {
                              echo '<small>Ditolak</small>';
                            } else {
                              echo '<small>Booking</small>';
                            }
                            ?>
                          </span>
                        </td>

                        <td><?php echo $lihat['nama_brg']; ?></td>
                        <td><?php echo $lihat['nama']; ?></td>
                        <td>
                          <?php
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
                          ?>
                        </td>
                        <td><?php echo $lihat['kuantitas']; ?></td>
                        <td><?php echo $lihat['catatan']; ?></td>

                        <td class="d-flex flex-row">
                          <?php if ($lihat['status'] == 0 && $lihat['status_pengajuan'] == 'Diajukan') { ?>
                            <form method="post" action="prosesapprovepengembalian.php" class="mr-2">
                              <input type="hidden" name="id_peminjaman" value="<?php echo $lihat['id_peminjaman']; ?>">
                              <input type="hidden" name="id_brg" value="<?php echo $lihat['id_brg']; ?>">
                              <input type="hidden" name="id_anggota" value="<?php echo $lihat['id_anggota']; ?>">
                              <input type="hidden" name="kuantitas" value="<?php echo $lihat['kuantitas']; ?>">
                              <input type="hidden" name="aksi_pengajuan" value="Disetujui">

                              <button type="submit" class="btn btn-sm btn-success">Setujui</button>
                            </form>
                            <form method="post" action="prosesapprovepengembalian.php">
                              <input type="hidden" name="id_peminjaman" value="<?php echo $lihat['id_peminjaman']; ?>">
                              <input type="hidden" name="id_brg" value="<?php echo $lihat['id_brg']; ?>">
                              <input type="hidden" name="id_anggota" value="<?php echo $lihat['id_anggota']; ?>">
                              <input type="hidden" name="kuantitas" value="<?php echo $lihat['kuantitas']; ?>">
                              <input type="hidden" name="aksi_pengajuan" value="Ditolak">

                              <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                            </form>
                          <?php } else if ($lihat['status'] == 1 && $lihat['status_pengajuan'] == 'Disetujui' && $lihat['aksi_pengajuan'] == 'Disetujui') { ?>
                            <span class="btn btn-sm btn-success disabled">Disetujui</span>
                          <?php } else if ($lihat['status'] == 0 && $lihat['status_pengajuan'] == 'Ditolak' && $lihat['aksi_pengajuan'] == 'Ditolak') { ?>
                            <span class="btn btn-sm btn-danger disabled">Ditolak</span>
                          <?php } else {  ?>
                            <span class="btn btn-sm btn-secondary disabled"><?php echo $lihat['aksi_pengajuan']; ?></span>
                          <?php } ?>
                        </td>
                        <td>
                          <span class="btn btn-sm disabled btn-<?php echo $lihat['status'] == 1 ? 'success' : 'danger' ?>">
                            <?php echo $lihat['status'] == 1 ? '<small>Sudah Dikembalikan</small>' : '<small>Belum Dikembalikan</small>'; ?>
                          </span>
                        </td>
                        <td>
                          <form action="hapuspeminjaman.php?id_peminjaman=<?php echo $lihat['id_peminjaman']; ?>" onsubmit="return confirm('Yakin ingin hapus <?php echo $lihat['nama_brg']; ?>?');" method="POST" class="d-flex flex-row">
                            <a href="editpeminjaman.php?id_peminjaman=<?php echo $lihat['id_peminjaman']; ?>" class="btn btn-warning mr-2">Edit</a>
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

    <script>
      // Mendapatkan referensi ke elemen input tanggal
      const inputTanggal = document.getElementById('tgl_pinjam');
      // Mendapatkan referensi ke elemen span untuk menampilkan waktu
      const displayTime = document.getElementById('displayTime');

      // Menambahkan event listener untuk menangani perubahan nilai input
      inputTanggal.addEventListener('input', function() {
        // Mendapatkan nilai tanggal dari input
        const tanggal = this.value;

        // Membuat objek Date berdasarkan nilai tanggal yang dipilih
        const tanggalPeminjaman = new Date(tanggal);

        // Mendapatkan jam dan menit dari tanggal
        let jam = tanggalPeminjaman.getHours();
        let menit = tanggalPeminjaman.getMinutes();

        // Menentukan apakah jam adalah AM atau PM
        const waktu = (jam < 12) ? 'AM' : 'PM';

        // Mengonversi jam menjadi format 12 jam
        jam = (jam % 12) || 12;

        // Format waktu dengan tambahan nol jika perlu
        const waktuFormatted = `${jam}:${menit < 10 ? '0' : ''}${menit} ${waktu}`;

        // Menampilkan waktu di samping input tanggal
        displayTime.textContent = waktuFormatted;
      });
    </script>
</body>