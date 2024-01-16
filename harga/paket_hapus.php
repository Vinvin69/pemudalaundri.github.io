<?php
require_once '../config.php';
$id = $_SESSION["username"];

// Validasi parameter kode_paket
if (!isset($_GET['kode_paket']) || empty($_GET['kode_paket'])) {
    die("Kode Paket tidak ditemukan.");
}

$kode_paket = $_GET['kode_paket'];

// Hapus data paket berdasarkan kode_paket
$query_delete = "DELETE FROM paket WHERE kode_paket = '$kode_paket'";
$result_delete = mysqli_query($connect, $query_delete);

// Validasi query delete
if (!$result_delete) {
    die("Query Error: " . mysqli_error($connect));
}

// Redirect ke halaman paket_index.php setelah menghapus
header("location: paket_index.php");
?>