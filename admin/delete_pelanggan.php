<?php
require_once '../config.php';

// Cek apakah parameter ID ada
if (isset($_GET['id'])) {
    // Ambil ID dari parameter GET
    $id_pelanggan = $_GET['id'];

    // Query untuk menghapus data pelanggan berdasarkan ID
    $query_delete = "DELETE FROM pembeli WHERE id_pelanggan = $id_pelanggan";
    $result_delete = mysqli_query($connect, $query_delete);

    if ($result_delete) {
        // Jika penghapusan berhasil, redirect ke halaman pelanggan.php
        header("Location: pelanggan.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        die("Query Error: " . mysqli_error($connect));
    }
} else {
    // Jika parameter ID tidak ditemukan, tampilkan pesan error
    die("Error: ID not found.");
}
?>