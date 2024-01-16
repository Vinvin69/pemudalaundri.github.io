<?php
require_once '../config.php';

// Query to retrieve data from the 'status' table
$query = "SELECT * FROM status";
$result = mysqli_query($connect, $query);

// Check if the query was successful
if (!$result) {
    die("Query error: " . mysqli_error($connect));
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Query untuk menghapus data berdasarkan ID
    $delete_query = "DELETE FROM status WHERE id = $delete_id";

    if (mysqli_query($connect, $delete_query)) {
        // Redirect kembali ke halaman transaksi.php setelah menghapus
        header("Location: transaksi.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($connect);
    }
    // Pastikan tidak ada output HTML atau spasi setelah exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Transaksi Admin</title>
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

    <div class="container">
        <div class="box-header">
            <h1>Status Pesanan</h1>
            <br>
        </div>

        <br>

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Tanggal Terima</th>
                    <th>Tanggal Selesai</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['tgl_terima']}</td>";
                    echo "<td>{$row['tgl_selesai']}</td>";
                    $total_formatted = number_format($row['jumlah_total_harga'], 0, ',', '.');
                    echo "<td>{$total_formatted}</td>";
                    echo "<td>{$row['keterangan']}</td>";
                    echo "<td class='button-column'>
                    <a href='transaksi_edit.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a>
                    <button class='btn btn-danger btn-sm' onclick='confirmDelete({$row['id']})'>Hapus</button>";

                    // Tampilkan tombol "Print" jika "keterangan" adalah "selesai"
                    if ($row['keterangan'] === 'selesai') {
                        echo "<a href='transaksi_print.php?id={$row['id']}' class='btn btn-success btn-sm' target='_blank'>Print</a>";
                    }

                    echo "</td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
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
        function confirmDelete(id) {
            var confirmation = confirm("Yakin ingin dihapus?");
            if (confirmation) {
                window.location.href = 'transaksi.php?delete_id=' + id;
            }
        }
    </script>
</body>

</html>
