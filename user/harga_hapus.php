<?php
// Pemeriksaan apakah sesi sudah aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once '../config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data sesuai id
    $query_delete = "DELETE FROM detail WHERE id = $id";
    $result_delete = mysqli_query($connect, $query_delete);

    if ($result_delete) {
        // Berhasil dihapus
        echo "success";
    } else {
        // Gagal dihapus
        echo "error";
    }
} else {
    // ID tidak tersedia
    echo "invalid";
}
?>