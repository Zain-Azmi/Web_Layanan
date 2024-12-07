<?php
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
$id = $_POST['id'];
$tanggal = $_POST['tanggal'];
$owner = $_POST['owner'];
$initiator = $_POST['initiator'];
$priority = $_POST['priority'];
$description = $_POST['description'];
$risk = $_POST['risk'];
$time = $_POST['time'];
$resources = $_POST['resources'];
$budget = $_POST['budget'];
$status = "Menunggu Persetujuan";

// Upload file
$file_name = $_FILES['file']['name'];
$file_tmp = $_FILES['file']['tmp_name'];
$upload_dir = "file/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

$file_path = $upload_dir . basename($file_name);

if (move_uploaded_file($file_tmp, $file_path)) {
    // Insert ke database
    $sql = "INSERT INTO request_for_change (id, tanggal, owner, initiator, priority, description, risk, time, resources, budget, file_path,status)
            VALUES ('$id', '$tanggal', '$owner', '$initiator', '$priority', '$description', '$risk', '$time', '$resources', '$budget', '$file_path','$status')";

    if ($koneksi->query($sql) === TRUE) {
        header("Location: dashboard.php");
    }
} else {
    echo "File upload gagal.";
}

// Tutup koneksi
$koneksi->close();
?>
