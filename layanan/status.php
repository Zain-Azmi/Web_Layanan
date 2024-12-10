<?php
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

// Hitung total RFC
$sql_total = "SELECT COUNT(*) AS total_rfc FROM request_for_change";
$result_total = $koneksi->query($sql_total);
$total_rfc = ($result_total->num_rows > 0) ? $result_total->fetch_assoc()['total_rfc'] : 0;

// Hitung jumlah RFC berdasarkan status
$sql_status = "
    SELECT 
        status,
        COUNT(*) AS count
    FROM request_for_change
    GROUP BY status
";
$result_status = $koneksi->query($sql_status);

// Simpan jumlah berdasarkan status dalam array
$status_counts = [
    'Menunggu Persetujuan' => 0,
    'Dibatalkan' => 0,
    'Diproses' => 0,
    'Selesai' => 0,
];

if ($result_status->num_rows > 0) {
    while ($row = $result_status->fetch_assoc()) {
        $status_counts[$row['status']] = $row['count'];
    }
}
$sql = "SELECT * FROM request_for_change";
$result = $koneksi->query($sql);

// Konversi data ke JSON
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$json_data = json_encode($data);

?>
<?php
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

// Mengambil data RFC berdasarkan status
$sql_menunggu = "SELECT * FROM request_for_change WHERE status = 'Menunggu Persetujuan'";
$sql_diproses = "SELECT * FROM request_for_change WHERE status = 'Diproses'";
$sql_selesai = "SELECT * FROM request_for_change WHERE status = 'Selesai'";
$sql_dibatalkan = "SELECT * FROM request_for_change WHERE status = 'Dibatalkan'";

// Menjalankan query untuk masing-masing status
$result_menunggu = $koneksi->query($sql_menunggu);
$result_diproses = $koneksi->query($sql_diproses);
$result_selesai = $koneksi->query($sql_selesai);
$result_dibatalkan = $koneksi->query($sql_dibatalkan);

// Fungsi untuk mengupdate status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $idd = strval($id);
    $action = $_POST['action'];

    if ($action == 'setujui') {
        $sql_update = "UPDATE request_for_change SET status = 'Diproses' WHERE id = '$id'";
        
    } elseif ($action == 'batalkan') {
        $sql_update = "UPDATE request_for_change SET status = 'Dibatalkan' WHERE id = '$id'";
    } elseif ($action == 'selesai') {
        $sql_update = "UPDATE request_for_change SET status = 'Selesai' WHERE id = '$id'";
    }
    
    // Menjalankan query update
    if ($koneksi->query($sql_update) === TRUE) {
        header('location:status.php');
    }
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


    table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #333; /* Border utama untuk tabel */
            margin-top: 20px;
        }
        thead {
            background-color:#7C847F;
            color: white;
        }
        th, td {
            border: 10px solid orange;
            padding: 8px;
            text-align: left;
        }
        th {
            text-transform: uppercase;
            font-size: 14px;
        }
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tbody tr:hover {
            background-color: #ddd;
        }
        .btn-action {
            background-color: #7C847F;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
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
            <a href="dashboard.php">Dashboard</a>
            <a href="status.php">Status</a>
            <a href="admin.php">Logout</a>
        </div>

    </nav>  
    <section class="pendaftaran" id="pendaftaran">
    <h3>Menunggu Persetujuan</h3>
    <table>
        <thead>
            <tr>
                <th>Unique ID</th>
                <th>Date of Submission</th>
                <th>Change Owner</th>
                <th>Initiator</th>
                <th>Priority</th>
                <th>Time Schedule</th>
                <th>Budget</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_menunggu->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['owner'] ?></td>
                <td><?= $row['initiator'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['time'] ?></td>
                <td><?= $row['budget'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="action" value="setujui" class="btn-action">Setujui</button>
                        <button type="submit" name="action" value="batalkan" class="btn-action">Batalkan</button>
                    </form>
                    <a href="detailrfc.php?id=<?= $row['id'] ?>" class="btn-detail">Lihat Detail</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Tabel Status: Diproses -->
    <h3>Diproses</h3>
    <table>
        <thead>
            <tr>
                <th>Unique ID</th>
                <th>Date of Submission</th>
                <th>Change Owner</th>
                <th>Initiator</th>
                <th>Priority</th>
                <th>Time Schedule</th>
                    <th>Budget</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_diproses->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['owner'] ?></td>
                <td><?= $row['initiator'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['time'] ?></td>
                <td><?= $row['budget'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="action" value="selesai" class="btn-action">Selesai</button>
                        <button type="submit" name="action" value="batalkan" class="btn-action">Batalkan</button>
                    </form>
                    <a href="detailrfc.php?id=<?= $row['id'] ?>" class="btn-detail">Lihat Detail</a>
                </td>
                
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Tabel Status: Selesai -->
    <h3>Selesai</h3>
    <table>
        <thead>
            <tr>
                <th>Unique ID</th>
                <th>Date of Submission</th>
                <th>Change Owner</th>
                <th>Initiator</th>
                <th>Priority</th>
                <th>Time Schedule</th>
                    <th>Budget</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_selesai->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['owner'] ?></td>
                <td><?= $row['initiator'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['time'] ?></td>
                <td><?= $row['budget'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><a href="detailrfc.php?id=<?= $row['id'] ?>" class="btn-detail">Lihat Detail</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Tabel Status: Dibatalkan -->
    <h3>Dibatalkan</h3>
    <table>
        <thead>
            <tr>
                <th>Unique ID</th>
                <th>Date of Submission</th>
                <th>Change Owner</th>
                <th>Initiator</th>
                <th>Priority</th>
                <th>Time Schedule</th>
                    <th>Budget</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_dibatalkan->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['owner'] ?></td>
                <td><?= $row['initiator'] ?></td>
                <td><?= $row['priority'] ?></td>
                <td><?= $row['time'] ?></td>
                <td><?= $row['budget'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><a href="detailrfc.php?id=<?= $row['id'] ?>" class="btn-detail">Lihat Detail</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
      <!-- Tabel Status: Menunggu Persetujuan -->
      
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
    <script>
        // Data JSON dari PHP
        const data = <?php echo $json_data; ?>;

        // Referensi untuk tabel status
        const statusSummary = document.getElementById("status-summary");
        const rfcTableBody = document.getElementById("rfcTableBody");

        // Menghitung jumlah RFC berdasarkan status
        const statusCounts = {
            'Menunggu Persetujuan': 0,
            'Dibatalkan': 0,
            'Diproses': 0,
            'Selesai': 0
        };

        // Isi tabel RFC dan hitung status
        data.forEach(row => {
            // Hitung status
            if (statusCounts[row.status] !== undefined) {
                statusCounts[row.status]++;
            }

            // Tabel Detail RFC
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${row.id}</td>
                <td>${row.tanggal}</td>
                <td>${row.owner}</td>
                <td>${row.initiator}</td>
                <td>${row.priority}</td>
                <td>${row.description}</td>
                <td>${row.risk}</td>
                <td>${row.time}</td>
                <td>${row.resources}</td>
                <td>${row.budget}</td>
                <td>${row.status}</td>
                <td><a href="${row.file_path}" target="_blank">Download</a></td>
                <td><a href="detailrfc.php?id=${row.id}" class="view-btn">Lihat Detail</a></td>

            `;
            rfcTableBody.appendChild(tr);
        });

        // Isi tabel summary berdasarkan statusCount
        for (const status in statusCounts) {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${status}</td>
                <td>${statusCounts[status]}</td>
            `;
            statusSummary.appendChild(tr);
        }
        // Menunggu sampai dokumen selesai dimuat
document.addEventListener('DOMContentLoaded', function() {
    // Pilih tabel, th, dan td
    const table = document.querySelectorAll('table, th, td');
    
    // Ubah border menjadi hitam
    table.forEach(element => {
        element.style.border = '1px solid black';  // Set border hitam
    });
});

        console.log(data); // Debugging untuk memastikan data JSON sudah diterima dengan benar

    </script>
    
</body>
</html>
