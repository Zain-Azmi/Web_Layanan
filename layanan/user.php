<?php
require 'fungsi.php';
session_start(); // Wajib di awal file untuk menggunakan session

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencari user di database
    $cekdatabase = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'and password='$password'");
    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung>0) {
        $user = mysqli_fetch_assoc($cekdatabase);
        // Jika username dan password cocok
        $_SESSION['log'] = true; // Tanda bahwa user sudah login
        $_SESSION['username'] = $username; // Simpan username ke session
        $_SESSION['user_id'] = $user['user_id']; // Simpan user_id ke session
        header('Location: user-loginberhasil.php'); // Redirect ke dashboard
        exit;
    } else {
        // Jika login gagal
        header('Location: user-logingagal.php');
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<style>.logonavbar {
    position: absolute;
    right: 51%; /* Sesuaikan dengan pergeseran yang diinginkan */
    margin-right: -2.5rem; /* Menggeser kembali setengah dari lebar logo */
    margin-left: auto; /* Mengatur margin kiri ke auto untuk menjaga logo tetap di kanan */
}

.logonavbar {
    border-radius: 20%;
    height: 5rem;
    width: 5rem;
}
.logonavbar1 {
    position: absolute;
    right: 47%; /* Sesuaikan dengan pergeseran yang diinginkan */
    margin-right: -2.5rem; /* Menggeser kembali setengah dari lebar logo */
    margin-left: auto; /* Mengatur margin kiri ke auto untuk menjaga logo tetap di kanan */
}

.logonavbar1 {
    border-radius: 20%;

}</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- icons -->
     <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="css/style login.css">
    <title>Web Layanan</title>
</head>
<body>

    <!-- navbar start --> 

    <nav class="navbar">
        <a href="#" class="navbar-logo"></a>
        <img class="logonavbar" src="gambar/layanan.png">
        <div class="navbar-nav">
        </div>
    </nav>

    <section class="pendaftaran" id="pendaftaran">
<h2>Login <span>User</span></h2>
        <div class="row">
            <form method="post">
            <div class="input-group">
                <i data-feather="user"></i>
                <input type="text" name="username" id="username" placeholder="Username"required>
            </div>
            <div class="input-group">
                <i data-feather="key"></i>
                <input type="password" name="password" id="password" placeholder="Password"required>
            </div>
            <button type="submit" class="btn" name="login" id="login">Login</button>
            <br><br>
            <div class="small">Belum punya akun? <a href="user-register.php"><b>Daftar</b></a> di sini
            </form>
        </div>
    </section>

    <!-- about -->

    <script>
      feather.replace();
    </script>

    <footer>
        <p>2024 ©InnoSphere IT Services.</p>
    </footer>

</body>
</html>