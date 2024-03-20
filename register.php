<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000">
    <link href="bootstrap/bootstrap-v5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="index.css">    

    <title>Register</title>
</head>

<body>
    <section class="bg-primary d-flex justify-content-center align-items-center" style="min-height: 100vh; background: linear-gradient(to bottom right, #4a90e2, #6fa4e7, #8cb9ec, #a8cfe1, #c5e5e6);">
        <div class="container py-5">
            <div class="row d-flex justify-content-center align-items-center h-100">

                <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                    <div class="card shadow-2-strong" style="background-color: rgba(255, 255, 255, 0.3); border-radius: 1rem;">
                        <div class="card-body px-sm-5 py-sm-4 p-3 text-center">                            
                            <h3 class="mt-3 mb-5">Registrasi</h3>
                            <?php                                                        
                            if (isset($_SESSION['registration_error'])) {
                                echo $_SESSION['registration_error'];
                                unset($_SESSION['registration_error']);
                            }

                            if (isset($_SESSION['registration_success'])) {
                                echo $_SESSION['registration_success'];
                                unset($_SESSION['registration_success']);                                
                            }
                            ?>

                            <form action="prosesregister.php" method="post">
                                <div class="form-outline">
                                    <input type="text" name="username" id="username" class="form-control" required autofocus/>
                                    <label class="form-label" for="username">Username</label>
                                </div>
                                <div class="form-outline">
                                    <input type="password" name="password" id="password" class="form-control" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="form-outline">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required />
                                    <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                                </div>
                                <div class="form-outline">
                                    <select name="divisi" id="divisi" class="form-select" aria-label="Default select example" required>
                                        <option selected value="">Pilih Divisi</option>                                        
                                        <option value="Divisi Kerja Program">Divisi Kerja Program</option>
                                        <option value="Divisi Kerja Media Baru">Divisi Kerja Media Baru</option>
                                        <option value="Divisi Kerja Berita">Divisi Kerja Berita</option>
                                        <option value="Divisi Kerja Teknik">Divisi Kerja Teknik</option>
                                        <option value="Divisi Kerja Umum">Divisi Kerja Umum</option>
                                    </select>
                                    <label for="divisi" class="form-label"></label>                                    
                                </div>
                                <div class="form-outline mb-0">
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                    <label for="phone" class="form-label">Nomor Telepon</label>                                    
                                </div>                                
                                <p class="text-start text-gray-400" style="font-size:13px"> (Terdiri dari 10 - 15 Angka)</p>
                                <button class="btn btn-primary btn-md btn-block mt-4 mb-3" type="submit">Daftar</button>
                                <p class="mb-0">Sudah punya akun? <a href="index.php">Masuk</a></p>
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