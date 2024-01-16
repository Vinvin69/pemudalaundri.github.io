<?php
require_once '../config.php';

// Ambil data dari tabel paket
$query_select = "SELECT * FROM paket";
$result = mysqli_query($connect, $query_select);

// Validasi query select
if (!$result) {
    die("Query Error: " . mysqli_error($connect));
}

// Proses input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_paket = mysqli_real_escape_string($connect, $_POST["nama_paket"]);
    $jumlah = $_POST["jumlah"];

    // Validasi input jumlah agar harus angka
    if (!is_numeric($jumlah)) {
        die("Error: Jumlah harus berupa angka.");
    }

    // Ambil harga paket dari opsi yang dipilih
    $query_get_harga = "SELECT harga_paket FROM paket WHERE nama_paket = '$nama_paket'";
    $result_get_harga = mysqli_query($connect, $query_get_harga);

    if (!$result_get_harga) {
        die("Query Error: " . mysqli_error($connect));
    }

    // Fetch harga_paket
    $row_harga = mysqli_fetch_assoc($result_get_harga);
    $harga_paket = $row_harga['harga_paket'];

    // Hitung total harga
    $total_harga = $jumlah * $harga_paket;

    // Ambil username (gantilah sesuai dengan mekanisme login yang Anda gunakan)
    session_start();
    $username = $_SESSION['username'];

    // Simpan data ke tabel "detail"
    $query_insert_detail = "INSERT INTO detail (username, nama_paket, harga_paket, jumlah_pesanan, total_harga) VALUES ('$username', '$nama_paket', '$harga_paket', '$jumlah', '$total_harga')";
    $result_insert_detail = mysqli_query($connect, $query_insert_detail);

    if (!$result_insert_detail) {
        die("Query Error: " . mysqli_error($connect));
    }

    // Simpan data ke session atau sebagai parameter pada redirect
    $_SESSION['total_harga'] = $total_harga;

    // Redirect ke harga.php
    header("Location: harga.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman input Pesanan</title>
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
            <!-- Add more sidebar items as needed -->
        </ul>
    </div>

    <div class="container">
        <div class="title-container">
            <h2 class="mt-10">Silahkan Isi Pesanan</h2>
        </div>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <div class="form-group">
                <label for="nama_paket" class="form-label">Paket:</label>
                <select class="form-select" name="nama_paket" id="nama_paket" required>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <option value="<?= $row['nama_paket'] ?>">
                            <?= $row['nama_paket'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label for="jumlah" class="form-label">Berat:</label>
                <input type="number" class="form-control" name="jumlah" id="jumlah" pattern="\d+" title="Masukkan angka"
                    required>
            </div>
            <br>
            <div class="form-group">
                <label for="total_harga" class="form-label">Total Harga:</label>
                <input type="text" class="form-control" name="total_harga" id="total_harga" readonly>
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

        document.addEventListener("DOMContentLoaded", function () {
            const jumlahInput = document.getElementById('jumlah');
            const totalHargaInput = document.getElementById('total_harga');
            const namaPaketSelect = document.getElementById('nama_paket');
            const cekHargaButton = document.createElement('button');

            cekHargaButton.innerText = 'Cek Harga';
            cekHargaButton.classList.add('btn', 'btn-primary');
            cekHargaButton.type = 'button'; // Menambahkan type="button"
            cekHargaButton.addEventListener('click', function () {
                // Ambil nama paket dari opsi yang dipilih
                var selectedOption = namaPaketSelect.value;
                // Ambil jumlah dari input
                var jumlah = parseFloat(jumlahInput.value);

                // Cek apakah kolom "Jumlah" sudah diisi
                if (isNaN(jumlah)) {
                    // Jika belum, kosongkan kolom "Total Harga"
                    totalHargaInput.value = '';
                    return;
                }

                // Kirim permintaan ke harga_button.php untuk mendapatkan total harga
                fetch('harga_button.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'nama_paket': selectedOption,
                        'jumlah': jumlah
                    }),
                })
                    .then(response => response.text())
                    .then(totalHarga => {
                        // Isi nilai total harga ke input tanpa menggunakan parseInt
                        totalHargaInput.value = totalHarga;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Sisipkan tombol "Cek Harga" setelah input jumlah
            jumlahInput.insertAdjacentElement('afterend', cekHargaButton);
        });
    </script>
</body>

</html>