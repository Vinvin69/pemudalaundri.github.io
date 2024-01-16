<?php
require_once '../config.php';

// Pemeriksaan apakah sesi sudah aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$id = $_SESSION["username"];

// Ambil data status sesuai username
$query = "SELECT
              username,
              MIN(tgl_terima) as tgl_terima,
              MAX(tgl_selesai) as tgl_selesai,
              SUM(total_harga) as total_harga,
              GROUP_CONCAT(keterangan ORDER BY tgl_terima ASC) as keterangan
          FROM nota
          WHERE username = '$id'
          GROUP BY username";

$result = mysqli_query($connect, $query);

// Validasi query select
if (!$result) {
    die("Query Error: " . mysqli_error($connect) . " Query: " . $query);
}

// Ambil hasil query
$row = mysqli_fetch_assoc($result);

// Proses form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $id;
    $tgl_terima = $_POST["tgl_terima"];
    $tgl_selesai = $_POST["tgl_selesai"];
    $keterangan = $_POST["keterangan"];

    // Ambil total harga dari tabel nota
    $total_harga_query = "SELECT SUM(total_harga) as total_harga FROM nota WHERE username = '$username'";
    $total_harga_result = mysqli_query($connect, $total_harga_query);

    if (!$total_harga_result) {
        die("Query Error: " . mysqli_error($connect) . " Query: " . $total_harga_query);
    }

    $total_harga_row = mysqli_fetch_assoc($total_harga_result);
    $jumlah_total_harga = $total_harga_row['total_harga'];

    // Simpan data ke tabel "status"
    $insertQuery = "INSERT INTO status (username, tgl_terima, tgl_selesai, jumlah_total_harga, keterangan)
                    VALUES ('$username', '$tgl_terima', '$tgl_selesai', '$jumlah_total_harga', '$keterangan')";

    $insertResult = mysqli_query($connect, $insertQuery);

    // Validasi query insert
    if (!$insertResult) {
        die("Query Error: " . mysqli_error($connect) . " Query: " . $insertQuery);
    }

    // Redirect to transaksi.php after successful submission
    header("Location: transaksi.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Add your CSS and Bootstrap links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    .container-fluid {
        height: 100%;
        display: flex;

    }

    #sidebar {
        display: flex;
        width: 250px;
        min-height: 100%;
        background-color: #343a40;
        flex-direction: column;
        padding-top: 56px;
        margin-right: 50px;
        flex: 0 0 auto;
    }

    main {
        flex: 1;
        padding-top: 100px;
    }

    .navbar {
        background-color: #bf1802;
        height: 56px;
    }

    .navbar-brand {
        color: white;
        font-weight: 700;
    }

    .nav-item {
        margin-bottom: 10px;
    }

    /* .nav-link {
        color: white;
    } */

    .nav-link.active {
        font-weight: 800;
    }

    .avatar {
        position: relative;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .avatar img {
        width: 150px;
        border-radius: 50%;
        border: 5px solid #FFFFFF;
    }
</style>

<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-sm navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Pemuda Laundri</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-xl-nowrap">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky bg-dark">
                    <!-- Sidebar content goes here -->
                    <div class=avatar>
                        <img src="../pl-icon.jpg" class="img-fluid">
                    </div>

                    <ul class="nav flex-column" style="margin-top: 40px;">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">
                                Dashboard Admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../harga/paket_index.php">
                                Harga
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="pelanggan.php">
                                Pelanggan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="transaksi.php">
                                Transaksi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">
                                Log Out
                            </a>
                        </li>
                        <!-- Add more sidebar items as needed -->
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="box-header">
                    <h1>Edit Status Pesanan</h1>
                    <br>
                </div>

                <form action="edit_status.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="<?php echo $row['username']; ?>" readonly>
                    </div>
            
                    <div class="mb-3">
                        <label for="tgl_terima" class="form-label">Tanggal Terima</label>
                        <input type="date" class="form-control" id="tgl_terima" name="tgl_terima"
                            value="<?php echo $row['tgl_terima']; ?>">
                    </div>
            
                    <div class="mb-3">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai"
                            value="<?php echo $row['tgl_selesai']; ?>">
                    </div>
            
                    <div class="mb-3">
                        <label for="total_harga" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="total_harga" name="total_harga"
                            value="<?php echo $row['total_harga']; ?>" readonly>
                    </div>
            
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <select class="form-select" id="keterangan" name="keterangan">
                            <option value="proses" <?php echo ($row['keterangan'] == 'proses') ? 'selected' : ''; ?>>
                                Proses
                            </option>
                            <option value="selesai" <?php echo ($row['keterangan'] == 'selesai') ? 'selected' : ''; ?>>
                                Selesai
                            </option>
                        </select>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </main>
        </div>
    </div>

</body>

</html>