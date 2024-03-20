<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header('location:dashboard.php');
    } elseif ($_SESSION['role'] == 'anggota') {
        header('location:home.php');
    }
}
$nonce = bin2hex(openssl_random_pseudo_bytes(32));
// 'nonce-$nonce' 'strict-dynamic'
header("Content-Security-Policy: base-uri 'self'; script-src 'self' 'unsafe-inline' https: http:; object-src 'none';");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000">
    <link href="bootstrap/bootstrap-v5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="manifest" href="manifest.json">
    <title>Login Staff</title>
</head>

<body>
    <section class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(to bottom right, #4a90e2, #6fa4e7, #8cb9ec, #a8cfe1, #c5e5e6);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">

                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="card shadow-2-strong" style="background-color: rgba(255, 255, 255, 0.3); border-radius: 1rem;">
                        <div class="card-body px-sm-5 py-sm-4 p-3 text-center">
                            <div class="mb-3 d-flex align-items-center justify-content-center">
                                <img src="images/logo.png" width="100px" alt="logo">
                            </div>
                            <h5 class="fw-bold">
                                APLIKASI
                                PEMINJAMAN
                                ALAT
                                SYUTING
                            </h5>
                            <hr>
                            <h3 class="mb-5">STAFF</h3>
                            <?php
                            if (isset($_SESSION['login_error'])) {
                                echo $_SESSION['login_error'];
                                unset($_SESSION['login_error']);
                            }

                            if (isset($_SESSION['validation_error'])) {
                                echo $_SESSION['validation_error'];
                                unset($_SESSION['validation_error']);
                            }
                            ?>
                            <form action="prosesloginanggota.php" method="post">
                                <div class="form-outline">
                                    <input type="text" name="username" id="username" class="form-control" required autofocus />
                                    <label class="form-label" for="username">Username</label>
                                </div>
                                <div class="form-outline">
                                    <input type="password" name="password" id="password" class="form-control" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <button class="btn btn-primary btn-md btn-block mt-4 mb-3" type="submit">Masuk</button>
                                <p class="mb-2">Belum punya akun? <a href="register.php">Daftar</a></p>
                                <p> Login sebagai admin? <a href="login_admin.php">Admin</a></p>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script nonce="<?= $nonce ?>">
        //  Menghilangkan alert setelah 4 detik
        setTimeout(function() {
            if (document.querySelector('.alert')) {
                document.querySelector('.alert').style.display = 'none';
            }
        }, 4000);

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/web_pinjam/service-worker.js')
                .then(registration => {
                    console.log('Service Worker registered with scope:', registration.scope);
                })
                .catch(error => {
                    console.error('Service Worker registration failed:', error);
                });
        }
    </script>
</body>

</html>