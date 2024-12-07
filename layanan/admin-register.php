<?php
require 'fungsi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>.logonavbar {
    position: absolute;
    right: 50%; /* Sesuaikan dengan pergeseran yang diinginkan */
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

    <link rel="stylesheet" href="css/style login copy.css">
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

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $konfirmasipassword = $_POST['confirmPassword'];

        // Cek apakah username sudah ada
        $sqlcheckusername = "SELECT username FROM user WHERE username=?";
        $stmtcheckusername = $koneksi->prepare($sqlcheckusername);
        $stmtcheckusername->bind_param("s", $username);
        $stmtcheckusername->execute();
        $stmtcheckusername->store_result();

        if ($stmtcheckusername->num_rows > 0) {
            echo "<script type='text/javascript'>
                window.location.href = 'admin-usernameada.php?success=1';
            </script>";
            $usernamesalah = "inputsalah";
            $passwordsalah = "";
        } else {
            // Jika username belum ada, lanjutkan ke validasi password
            $usernamesalah = "";
            if ($password !== $konfirmasipassword) {
                echo "<script type='text/javascript'>
                window.location.href = 'admin-konfirmasipassword.php?success=1';
            </script>";
                $passwordsalah = "inputsalah";
            } else {
                // Tambahkan user baru
                $sqlinsertuser = "INSERT INTO user (username, password) VALUES (?, ?)";
                $stmtinsertuser = $koneksi->prepare($sqlinsertuser);
                if (!$stmtinsertuser) {
                    die('Error: ' . $koneksi->error);
                }
                $stmtinsertuser->bind_param("ss", $username, $konfirmasipassword);

                if ($stmtinsertuser->execute()) {
                    echo "<script type='text/javascript'>
                            window.location.href = 'admin-registerberhasil.php?success=1';
                        </script>";
                } else {

                }
            }
        }

        $stmtcheckusername->close();
        if (isset($stmtinsertuser)) {
            $stmtinsertuser->close();
        }
        $koneksi->close();
    }
    ?>

    <section class="pendaftaran" id="pendaftaran">
<h2>Register <span>Admin</span></h2>
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
            <div class="input-group">
                <i data-feather="key"></i>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Konfirmasi Password"required>
            </div>
            <button type="submit" class="btn" name="register" id="register">Register</button>
            <br><br>
            <div class="small">Sudah punya akun? <a href="admin.php"><b>Login</b></a> di sini
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