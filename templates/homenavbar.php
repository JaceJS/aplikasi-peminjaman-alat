<nav class="navbar navbar-expand-lg bg-body-tertiary bg-white topbar mb-4 static-top shadow text-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="home.php">
            <img src="images/logo.png" width="80px" alt="logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <?php if ($role == 'admin') : ?>
                    <a class="nav-link fw-semibold me-3" href="dashboard.php">Dashboard</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold me-3" href="home.php">Beranda</a>                        
                </li>
                <li class="nav-item">
                    <?php if ($role == 'anggota') : ?>
                    <a class="nav-link fw-semibold me-3" href="daftarpinjam.php">Daftar Pinjam</a>
                    <?php endif; ?>
                </li>                    
                <li class="nav-item">
                    <?php if ($role == 'anggota') : ?>
                    <a class="nav-link fw-semibold me-3" href="riwayatpeminjaman.php">Riwayat Peminjaman</a>
                    <?php endif; ?>
                </li>                    
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-lg-inline fw-semibold"><?php echo $username?></span>                                                    
                    </a>                        
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" style="min-width: 110px" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13px" height="13px">
                                <path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/>
                            </svg>
                            <span class="ms-2">Logout</span>
                        </a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
            <button class="close btn btn-xs border" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">Tekan tombol logout di bawah untuk keluar</div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="logout.php">Logout</a>
            <button class="btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </div>
    </div>
</div>