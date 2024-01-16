<?php
require_once '../config.php';
$id = $_SESSION["username"];

// Proses input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_paket = $_POST["kode_paket"];
    $nama_paket = $_POST["nama_paket"];
    $harga_paket = $_POST["harga_paket"];

    // Simpan data ke database
    $query = "INSERT INTO paket (kode_paket, nama_paket, harga_paket) VALUES ('$kode_paket', '$nama_paket', '$harga_paket')";
    $result_insert = mysqli_query($connect, $query);

    // Validasi query insert
    if (!$result_insert) {
        die("Query Error: " . mysqli_error($connect));
    } else {
        header("Location: paket_index.php");
        exit();
    }

}

// Ambil data dari tabel paket
$query_select = "SELECT * FROM paket";
$result = mysqli_query($connect, $query_select);

// Validasi query select
if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tambah Data Paket atau Paket admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    * {
        margin: 0;
        padding: 0;
    }

    body {
        background-color: white;
    }

    .header {
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        padding: 15px 20px;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-right: 20px;
    }

    .toggle {
        background: transparent;
        border: none;
        width: 30px;
        height: 30px;
        cursor: pointer;
        outline: 0;
    }

    .toggle span {
        width: 30px;
        height: 3px;
        background: #555;
        display: block;
        position: relative;
        cursor: pointer;
    }

    .toggle span:before,
    .toggle span:after {
        content: '';
        position: absolute;
        left: 0;
        width: 100%;
        height: 100%;
        background: #555;
        transition: all 0.3s ease-out;
    }

    .toggle span:before {
        top: -8px;
    }

    .toggle span:after {
        top: 8px;
    }

    .toggle span.toggle {
        background: transparent;
    }

    .toggle span.toggle:before {
        top: 0;
        transform: rotate(-45deg);
        background: #4CAF50;
        margin-right: 20px;
    }

    .toggle span.toggle:after {
        top: 0;
        transform: rotate(45deg);
        background: #4CAF50;
        margin-right: 20px;
    }

    .sidebar {
        background: #fff;
        width: 235px;
        position: fixed;
        top: 0;
        left: -235px;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        padding-top: 90px;
        transition: all 0.3s ease-out;
    }


    .sidebar ul {
        list-style: none;
    }

    .sidebar ul li {
        display: block;
    }

    .sidebar ul li a {
        padding: 8px 15px;
        font-size: 16px;
        color: #222;
        font-family: arial;
        text-decoration: none;
        display: block;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease-out;
        font-weight: 500;
    }

    .sidebar ul li a:before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        right: 50%;
        transform: translate(-50%, -50%);
        width: 0;
        height: 1px;
        background: #4CAF50;
        z-index: -1;
        transition: all 0.3s ease-out;
    }

    .sidebar ul li a:hover:before {
        width: 100%;
    }

    .sidebar ul li a:hover {
        color: #4CAF50;
    }

    .sidebarshow {
        left: 0;
    }

    .avatar {
        text-align: center;
        /* Pusatkan gambar dalam avatar */
        margin-top: 20px;
    }

    .avatar img {
        width: 150px;
        /* Sesuaikan lebar gambar sesuai kebutuhan */
        height: 150px;
        /* Sesuaikan tinggi gambar sesuai kebutuhan */
        max-width: 100%;
        border-radius: 50%;
        border: 5px solid #FFFFFF;
    }

    .header h1 {
        margin-right: 40px;
        /* Sesuaikan dengan margin yang diinginkan */
    }

    .container {
        padding-top: 100px;
        padding-left: 20px;
        padding-right: 20px;
    }
</style>

<body>
    <header class="header">
        <button type="button" class="toggle" id="toggle">
            <span></span>
        </button>
        <h1>Pemuda Laundri</h1>
    </header>

    <div class="sidebar" id='sidebar'>
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
                <a class="nav-link" href="nota.php">
                    Nota Pelanggan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaksi.php">
                    Status Transaksi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">
                    Log Out
                </a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="title-container">
            <h2 class="mt-10">Tambah Data Paket</h2>
        </div>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="form-group">
                <label for="kode_paket" class="form-label">Kode Paket:</label>
                <input type="text" class="form-control" name="kode_paket" required>
            </div>
            <div class="form-group">
                <label for="nama_paket" class="form-label">Nama Paket:</label>
                <input type="text" class="form-control" name="nama_paket" required>
            </div>
            <div class="form-group">
                <label for="harga_paket" class="form-label">Harga Paket:</label>
                <input type="text" class="form-control" name="harga_paket" required>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Tambah Data</button>
            </div>
        </form>
    </div>

    <script>
        var btn = document.querySelector('.toggle');
        var btnst = true;
        btn.onclick = function () {
            if (btnst == true) {
                document.querySelector('.toggle span').classList.add('toggle');
                document.getElementById('sidebar').classList.add('sidebarshow');
                btnst = false;
            } else if (btnst == false) {
                document.querySelector('.toggle span').classList.remove('toggle');
                document.getElementById('sidebar').classList.remove('sidebarshow');
                btnst = true;
            }
        }
    </script>
</body>

</html>