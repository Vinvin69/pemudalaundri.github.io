<?php
session_start();
include('../config.php');

// Ambil data dari tabel "detail"
$query = "SELECT * FROM detail WHERE username = '$_SESSION[username]'";
$result_detail = mysqli_query($connect, $query); // Perhatikan bahwa $koneksi diganti menjadi $connect

// Inisialisasi variabel $result untuk menghindari undefined variable
$result = [];

if (isset($_POST['submit_pesanan'])) {
    // Loop untuk memasukkan data ke tabel "nota" dan hapus dari "detail"
    while ($row_detail = mysqli_fetch_assoc($result_detail)) {
        $nama_paket = $row_detail['nama_paket'];
        $jumlah_pesanan = $row_detail['jumlah_pesanan'];
        $total_harga = $row_detail['total_harga'];
        $keterangan = $row_detail['keterangan']; // Ambil keterangan dari "detail"

        // Tetapkan nilai "proses" ke variabel keterangan
        $keterangan = 'proses';

        // Query untuk memasukkan data ke tabel "nota" dengan keterangan
        $insert_query = "INSERT INTO nota (username, nama_paket, jumlah_pesanan, total_harga, keterangan)
             VALUES ('$_SESSION[username]', '$nama_paket', '$jumlah_pesanan', '$total_harga', '$keterangan')";

        mysqli_query($connect, $insert_query); // Perhatikan bahwa $koneksi diganti menjadi $connect
    }

    // Hapus data dari tabel "detail" sesuai username
    $delete_query = "DELETE FROM detail WHERE username = '$_SESSION[username]'";
    mysqli_query($connect, $delete_query); // Perhatikan bahwa $koneksi diganti menjadi $connect

    // Refresh halaman setelah data dikirim dan dihapus
    header("Location: harga.php");
    exit();
}

// Dapatkan data untuk menampilkan pada tabel
$query_result = mysqli_query($connect, "SELECT * FROM detail WHERE username = '$_SESSION[username]'");
$result = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pesanan</title>
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
        <div class="box-header">
            <h1>Pesan</h1>
            <br>
            <a href="harga_input.php">
                <button type="button" class="btn btn-primary">Tambah Pesanan</button>
            </a>
        </div>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Paket</th>
                    <th>Berat (KG)</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result_detail)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td class='harga-paket' data-total-harga='" . $row['total_harga'] . "' data-username='" . $row['username'] . "'>" . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['jumlah_pesanan'] . "</td>";
                    echo "<td>" . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                    echo "<td><button class='btn btn-danger delete-btn' data-id='" . $row['id'] . "'>Delete</button></td>";
                    echo "</tr>";
                }

                ?>
            </tbody>
        </table>
        <!-- Tambahkan button dan input di atas tabel -->
        <form method="post" action="harga.php">
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <button type="button" id="totalButton" class="btn btn-info">Total Pesanan</button>
                    <button type="submit" name="submit_pesanan" class="btn btn-primary">Submit Pesanan</button>
                </div>
                <input type="text" id="totalInput" name="totalInput" class="form-control mt-2" readonly>
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
            var deleteButtons = document.querySelectorAll('.delete-btn');
            var totalButton = document.getElementById('totalButton');
            var totalInput = document.getElementById('totalInput');
            var hargaPaketElements = document.querySelectorAll('.harga-paket');

            deleteButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var userConfirmed = confirm('Apakah Anda yakin ingin menghapus data ini?');
                    if (userConfirmed) {
                        var id = button.getAttribute('data-id');
                        fetch('harga_hapus.php?id=' + id)
                            .then(response => response.text())
                            .then(result => {
                                if (result === 'success') {
                                    var row = button.closest('tr');
                                    row.parentNode.removeChild(row);
                                    updateTotal();
                                } else if (result === 'error') {
                                    alert('Gagal menghapus data.');
                                } else {
                                    alert('ID tidak valid atau data tidak ditemukan.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan.');
                            });
                    }
                });
            });

            totalButton.addEventListener('click', function (event) {
                event.preventDefault();
                updateTotal();
            });


            function updateTotal() {
                var total = 0;
                hargaPaketElements.forEach(function (element) {
                    total += parseFloat(element.getAttribute('data-total-harga')) || 0;
                });

                totalInput.value = total.toLocaleString();
            }
        });
    </script>
</body>

</html>