<?php
require_once '../config.php';

// Query untuk mengambil data dari tabel "status" dengan keterangan 'selesai'
$query = "SELECT * FROM status WHERE keterangan = 'selesai'";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Query error: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pembayaran Pemuda Laundri</title>
    <!-- Add your CSS and Bootstrap links here -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script>
        window.onload = function () {
            window.print(); // Otomatis mencetak halaman saat dimuat
        };
    </script>
</head>

<body>

    <div class="container mt-5">
        <h2>Nota Pembayaran Pemuda Laundri</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Tanggal Terima</th>
                    <th>Tanggal Selesai</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Loop through the data and display it in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$no}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['tgl_terima']}</td>";
                    echo "<td>{$row['tgl_selesai']}</td>";
                    // Menggunakan number_format untuk memformat angka dengan titik
                    echo "<td>" . number_format($row['jumlah_total_harga'], 0, ',', '.') . "</td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Add your scripts and Bootstrap JS links here -->
    <script src="your-bootstrap-scripts.js"></script>
</body>

</html>