<?php
include "../config.php";

// Pastikan pengguna sudah login sebelum dapat mengakses halaman profile edit
if (!isset($_SESSION["login"]) || !$_SESSION["login"]) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user"];

// Jika form disubmit, proses update data pengguna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newNamaPelanggan = $_POST["new_nama_pelanggan"];
    $newJenisKelamin = $_POST["new_jenis_kelamin"];
    $newTelp = $_POST["new_telp"];
    $newAlamat = $_POST["new_alamat"];

    $updateQuery = "UPDATE pembeli 
                    SET nama_pelanggan = '$newNamaPelanggan', 
                        jenis_kelamin = '$newJenisKelamin', 
                        telp = '$newTelp', 
                        alamat = '$newAlamat' 
                    WHERE id_pelanggan = '$user_id'";

    $updateResult = mysqli_query($connect, $updateQuery);

    if ($updateResult) {
        $_SESSION['update_success'] = "Profil berhasil diperbarui!";
        header("Location: profile.php");
        exit();
    } else {
        $error = true;
        echo "Error: " . mysqli_error($connect);
    }
}

// Ambil data pengguna dari database
$query = "SELECT username, nama_pelanggan, jenis_kelamin, telp, alamat FROM pembeli WHERE id_pelanggan = '$user_id'";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query error: " . mysqli_error($connect));
}

// Ambil data pengguna sebagai asosiatif array
$user_data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman edit profile</title>
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
                    Dashboard Pelanggan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">
                    Profile
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="harga.php">
                    Pesan Laundri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../Status/status_index.php">
                    Status
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
        <div class="card-header">
            <h3 class="text-center">Edit Profile</h3>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div id="errorAlert" class="alert alert-danger w-75 mx-auto mt-4">
                    <p class="font-weight-bold m-0 text-center">Maaf, terjadi kesalahan saat pembaruan profil
                    </p>
                </div>
                <script>
                    setTimeout(function () {
                        document.getElementById("errorAlert").style.display = "none";
                    }, 3000);
                </script>
            <?php endif; ?>
            <form method="post" action="">
                <div class="mb-3">
                    <label for="new_nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="new_nama_pelanggan" name="new_nama_pelanggan"
                        value="<?= $user_data["nama_pelanggan"]; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="new_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-select" id="new_jenis_kelamin" name="new_jenis_kelamin" required>
                        <option value="male" <?= ($user_data["jenis_kelamin"] == 'male') ? 'selected' : ''; ?>>
                            Male
                        </option>
                        <option value="female" <?= ($user_data["jenis_kelamin"] == 'female') ? 'selected' : ''; ?>>
                            Female
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="new_telp" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control" id="new_telp" name="new_telp"
                        value="<?= $user_data["telp"]; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="new_alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="new_alamat" name="new_alamat"
                        required><?= $user_data["alamat"]; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
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