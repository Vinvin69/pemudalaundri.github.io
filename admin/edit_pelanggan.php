<?php
require_once '../config.php';

// Ambil ID pelanggan dari parameter GET
$id_pelanggan = $_GET['id'];

// Ambil data pelanggan berdasarkan ID
$query_select = "SELECT * FROM pembeli WHERE id_pelanggan = $id_pelanggan";
$result = mysqli_query($connect, $query_select);

// Validasi query select
if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}

// Ambil data pelanggan dari hasil query
$row = mysqli_fetch_assoc($result);

// Proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $jenis_kelamin = mysqli_real_escape_string($connect, $_POST["jenis_kelamin"]);
    $telp = mysqli_real_escape_string($connect, $_POST["telp"]);
    $alamat = mysqli_real_escape_string($connect, $_POST["alamat"]);

    // Validasi No HP agar hanya berisi angka
    if (!is_numeric($telp)) {
        die("Error: No HP harus berupa angka.");
    }

    // Query untuk update data pelanggan
    $query_update = "UPDATE pembeli SET 
                     username = '$username',
                     jenis_kelamin = '$jenis_kelamin',
                     telp = '$telp',
                     alamat = '$alamat'
                     WHERE id_pelanggan = $id_pelanggan";

    $result_update = mysqli_query($connect, $query_update);

    if (!$result_update) {
        die("Query Error: " . mysqli_error($connect));
    }

    // Redirect ke halaman pelanggan.php setelah update
    header("Location: pelanggan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Edit Profile</title>
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
        padding-left: 10px;
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
            <!-- Add more sidebar items as needed -->
        </ul>
    </div>

    <div class="container mt-5">
        <h2>Edit Data Pelanggan</h2>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id_pelanggan ?>" method="post">
            <br>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" value="<?= $row['username'] ?>"
                    required>
            </div>
            <br>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" required>
                    <option value="male" <?= ($row['jenis_kelamin'] === 'male') ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?= ($row['jenis_kelamin'] === 'female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="telp">No HP:</label>
                <input type="tel" class="form-control" name="telp" id="telp" pattern="\d+" title="Masukkan angka saja"
                    value="<?= $row['telp'] ?>" required>
                <small id="telpHelp" class="form-text text-muted">Hanya diizinkan angka.</small>
            </div>
            <br>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="3"
                    required><?= $row['alamat'] ?></textarea>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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