<?php
session_start();

if (!isset($_SESSION['log'])) {
    // Jika session login tidak ada, redirect ke halaman login
    header('Location: admin.php');
    exit;
}
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "layanan"; // Ganti dengan nama database Anda

$koneksi = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Ambil ID RFC dari URL
$rfc_id = $_GET['id']; // ID RFC dikirim melalui query string

// Query untuk mengambil data RFC berdasarkan ID
$sql = "SELECT * FROM request_for_change WHERE id = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $rfc_id);  // "s" for string
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah data RFC ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 7%;
    background-color: #e97431ba;
    border-bottom: 1px solid var(--primary);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999 ;
    height: 6rem;
}

.logonavbar {
    position: absolute;
    right: 90%; /* Sesuaikan dengan pergeseran yang diinginkan */
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
    right: 84%; /* Sesuaikan dengan pergeseran yang diinginkan */
    margin-right: -2.5rem; /* Menggeser kembali setengah dari lebar logo */
    margin-left: auto; /* Mengatur margin kiri ke auto untuk menjaga logo tetap di kanan */
}

.logonavbar1 {
    border-radius: 20%;

}

.navbar .navbar-nav a {
    color: #EFEEE5;
    display: inline-block;
    font-size: 1.4rem;
    margin: 0 1rem;

}

.navbar .navbar-nav a:hover {
    color :#da6b21; 
}

.navbar .navbar-nav a::after{
    content: '';
    display: block;
    padding-bottom: 0.5rem;
    border-bottom: 0.1rem solid var(--primary);
    transform: scaleX(0);
    transition: 0.2s;
}

.navbar .navbar-nav a:hover::after{
    transform: scaleX(0.5);
} 

.navbar .navbar-extra a {
    color: var(--bg);
    margin: 0 0.5rem;
}

.navbar .navbar-extra a:hover {
    color: var(--primary);
}</style>
<style>
        .pendaftaran .row form .input-group select{
    width: 100%;
    padding: 0.6rem;
    font-size: 1rem;
    background: none;
    color: #fff;

}
.pendaftaran .row .btn {
    margin-top: 1rem;
    position: relative;
    top:-60px;
    display: inline-block;
    padding: 0.5rem 1.5rem ;
    font-size: 1rem;
    color: #fff;
    background-color: #7C847F;
    border-radius: 10px;
    cursor: pointer;
}
.pendaftaran .row form .input-group select option{
            width: 100%;
            padding: 0.6rem;
            font-size: 1rem;
            background: none;
            color: #7C847F;
}
.pendaftaran .row form .input-group select optgroup{
            width: 100%;
            padding: 0.6rem;
            font-size: 1rem;
            background: none;
            color: #7C847F;
}
.pendaftaran .row form .input-group textarea{

    min-height:10rem;
    height: auto;
        width: 100%;
        padding: 0.6rem;
        font-size: 1rem;
        background: none;
        color: #fff;
            display: flex;
            align-items: center; /* Memastikan ikon dan textarea sejajar vertikal */
            margin-right: 10px; /* Jarak antara ikon dan textarea */
            resize:none;
    }


    
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- icons -->
     <script src="https://unpkg.com/feather-icons"></script>
     <link href="path-to-select2.min.css" rel="stylesheet">
     <script src="path-to-select2.min.js"></script>
    <link rel="stylesheet" href="css/styleadmin.css">
    <title>Web Layanan</title>
</head>

<body>
    <!-- navbar start --> 

    <nav class="navbar">
        <a href="index.php" class="navbar-logo"></a>
        <img class="logonavbar" src="gambar/layanan.png">
        <div class="navbar-nav">
        <a href="userdashboard.php">Dashboard</a>
            <a href="pengajuan.php">Pengajuan</a>
            <a href="user-logout.php">Logout</a>
        </div>

    </nav>  
    <section class="pendaftaran" id="pendaftaran">
        <div class="row">
        <form action="prosesrfc.php" method="POST" enctype="multipart/form-data">
            <h2>Request <span>For Change
            </span></h2>
            <div class="input-group">
                        <i data-feather="user"></i>
                        <label for="id">Unique ID:</label>
                        <input type="text" id="id" name="id" value="<?php echo $row['id']; ?>"readonly>
                    </div>
                    <div class="input-group">
                        <label for="tanggal">Date of submission:</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label for="owner">Change Owner:</label>
                        <input type="text" id="owner" name="owner" value="<?php echo $row['owner']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label for="initiator">Initiator of the RFC:</label>
                        <input type="text" id="initiator" name="initiator" value="<?php echo $row['initiator']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label for="priority">Proposed Change Priority:</label>
                        <select id="priority" name="priority" disabled>
                            <option value="1" <?php echo $row['priority'] == 1 ? 'selected' : ''; ?>>High</option>
                            <option value="2" <?php echo $row['priority'] == 2 ? 'selected' : ''; ?>>Medium</option>
                            <option value="3" <?php echo $row['priority'] == 3 ? 'selected' : ''; ?>>Low</option>
                            <option value="4" <?php echo $row['priority'] == 4 ? 'selected' : ''; ?>>Urgent</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="description">Description of the Change being applied for:</label>
                        <textarea id="description" name="description" readonly><?php echo $row['description']; ?></textarea>
                    </div>
                    <div class="input-group">
                        <label for="risk">Risk during the Implementation:</label>
                        <textarea id="risk" name="risk" readonly><?php echo $row['risk']; ?></textarea>
                    </div>
                    <div class="input-group">
                        <label for="time">Time Schedule:</label>
                        <input type="text" id="time" name="time" value="<?php echo $row['time']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <label for="resources">Estimate of resources for the implementation:</label>
                        <textarea id="resources" name="resources" readonly><?php echo $row['resources']; ?></textarea>
                    </div>
                    <div class="input-group">
                        <label for="budget">Budget:</label>
                        <input type="text" id="budget" name="budget" value="<?php echo $row['budget']; ?>" readonly>
                    </div>
                    <div class="input-group">
                        <i data-feather="home"></i>
                        <label for="file">Additional supporting Documents:</label>
                        <br>
                        <p><a href="<?php echo $row['file_path']; ?>" target="_blank">Download</a></p>
                    </div>

            </form>
        </div>
    </section>
    <footer>
        <p>2024 ©InnoSphere IT Services.</p>
    </footer>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var datatable = new simpleDatatables.DataTable("#datatablesSimple");
    });
    const textarea = document.getElementById('description');

textarea.addEventListener('input', function () {
    this.style.height = 'auto'; // Reset tinggi untuk perhitungan ulang
    this.style.height = this.scrollHeight + 'px'; // Set tinggi sesuai konten
});
const textarea2 = document.getElementById('risk');

textarea2.addEventListener('input', function () {
    this.style.height = 'auto'; // Reset tinggi untuk perhitungan ulang
    this.style.height = this.scrollHeight + 'px'; // Set tinggi sesuai konten
});
const textarea3 = document.getElementById('resources');

textarea3.addEventListener('input', function () {
    this.style.height = 'auto'; // Reset tinggi untuk perhitungan ulang
    this.style.height = this.scrollHeight + 'px'; // Set tinggi sesuai konten
});
    </script>
    
</body>
</html>
