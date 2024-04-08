<?php
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header('location:dashboard.php');
    } elseif ($_SESSION['role'] == 'anggota') {
        header('location:home.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000">
    <link href="bootstrap/bootstrap-v5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">

    <title>Login Admin</title>
</head>

<body>
    <section class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(to bottom right, #3498db, #2ecc71);">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">

                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="card shadow-2-strong" style="background-color: rgba(255, 255, 255, 0.3); border-radius: 1rem;">
                        <div class="card-body px-sm-5 py-sm-4 p-3 text-center">
                            <div class="mb-3 d-flex align-items-center justify-content-center">
                                <!-- <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px">
                                    <svg fill="white" class="text-white" xmlns="http://www.w3.org/2000/svg" height="1.7em" viewBox="0 0 448 512">
                                        <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z" />
                                    </svg>
                                </div> -->
                                <img src="images/logo.svg" width="100px" alt="logo">
                            </div>
                            <h5 class="fw-bold">
                                APLIKASI
                                PEMINJAMAN
                                ALAT
                                SYUTING
                            </h5>
                            <hr>
                            <h3 class="mb-5">ADMIN</h3>
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
                            <form action="prosesloginadmin.php" method="post">
                                <div class="form-outline">
                                    <input type="text" name="username" id="username" class="form-control" required autofocus />
                                    <label class="form-label" for="username">Username</label>
                                </div>
                                <div class="form-outline">
                                    <input type="password" name="password" id="password" class="form-control" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <button class="btn btn-success btn-md btn-block mt-4 mb-3" type="submit">Masuk</button>
                                <p class="mb-0">Login sebagai anggota? <a href="index.php">Anggota</a></p>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.display = 'none';
        }, 4000);
    </script>
</body>

</html>