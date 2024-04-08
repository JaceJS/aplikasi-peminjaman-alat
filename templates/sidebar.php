<?php
define('BASE_URL', 'https://web-pinjam.test');

$current_page = basename($_SERVER['PHP_SELF']);
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo BASE_URL; ?>">
        <div class="sidebar-brand-icon">
            <img src="<?php echo BASE_URL; ?>/images/logo.svg" width="80px" alt="logo">
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider mb-3">

    <div class="sidebar-heading">
        Manajemen Alat
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard.php">
            <i class="fas fa-fw fa-chart-pie"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($current_page == 'alat.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/menu/alat/alat.php">
            <i class="fas fa-fw fa-box"></i>
            <span>Alat</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($current_page == 'peminjam.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/menu/peminjam/peminjam.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Anggota Peminjam</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($current_page == 'peminjaman.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/menu/peminjaman/peminjaman.php">
            <i class="fas fa-fw fa-shopping-bag"></i>
            <span>Peminjaman</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($current_page == 'pengembalian.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/menu/pengembalian/pengembalian.php">
            <i class="fas fa-fw fa-undo"></i>
            <span>Pengembalian</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Sidebar Heading -->
    <div class="sidebar-heading mt-5">
        Manajemen Akun
    </div>

    <li class="nav-item <?php echo ($current_page == 'akun.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?php echo BASE_URL; ?>/menu/akun/akun.php">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Akun Admin</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>