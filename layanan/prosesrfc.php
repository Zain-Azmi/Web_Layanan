<?php
session_start();
$user_id = $_SESSION['user_id'];

// koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "layanan"; // Ganti dengan nama database Anda

$koneksi = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Ambil data dari form
$id = mysqli_real_escape_string($koneksi, $_POST['id']);
$tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
$owner = mysqli_real_escape_string($koneksi, $_POST['owner']);
$initiator = mysqli_real_escape_string($koneksi, $_POST['initiator']);
$priority = mysqli_real_escape_string($koneksi, $_POST['priority']);
$description = mysqli_real_escape_string($koneksi, $_POST['description']);
$risk = mysqli_real_escape_string($koneksi, $_POST['risk']);
$time = mysqli_real_escape_string($koneksi, $_POST['time']);
$resources = mysqli_real_escape_string($koneksi, $_POST['resources']);
$budget = mysqli_real_escape_string($koneksi, $_POST['budget']);
$status = "Menunggu Persetujuan";
$user_id = $_SESSION['user_id'];

// Upload file
$file_name = $_FILES['file']['name'];
$file_tmp = $_FILES['file']['tmp_name'];
$upload_dir = "file/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_path = $upload_dir . basename($file_name);

// Check for file upload success
if (move_uploaded_file($file_tmp, $file_path)) {
    // Insert ke database
    $sql = "INSERT INTO request_for_change (id, tanggal, owner, initiator, priority, description, risk, time, resources, budget, file_path, status, user_id)
            VALUES ('$id', '$tanggal', '$owner', '$initiator', '$priority', '$description', '$risk', '$time', '$resources', '$budget', '$file_path', '$status', '$user_id')";

    if ($koneksi->query($sql) === TRUE) {
        header("Location: userdashboard.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} else {
    echo "File upload gagal.";
}

// Tutup koneksi
$koneksi->close();
?>
