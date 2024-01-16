<?php
session_start();
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    $query = "SELECT SUM(total_harga) AS total FROM detail WHERE username = '$username'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo $row['total'];
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>