<?php
require_once '../config.php';

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

    // Kembalikan total harga sebagai respon
    echo $total_harga;
} else {
    // Jika bukan POST request, berikan pesan error
    echo "Error: Invalid request method.";
}
?>