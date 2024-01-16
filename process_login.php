<?php
// web_pi/process_login.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Simpan informasi pengguna dan kata sandi yang benar di sini
    $adminUsername = "admin";
    $adminPassword = "adminpassword";

    $userUsername = "user";
    $userPassword = "userpassword";

    // Periksa login
    if ($username == $adminUsername && $password == $adminPassword) {
        // Jika login sebagai admin, arahkan ke halaman admin
        header("Location: /web_pi/admin/index.php");
        exit();
    } elseif ($username == $userUsername && $password == $userPassword) {
        // Jika login sebagai user, arahkan ke halaman user
        header("Location: /web_pi/user/index.php");
        exit();
    } else {
        // Jika login gagal, arahkan kembali ke halaman login
        header("Location: login.php");
        exit();
    }
} else {
    // Jika bukan metode POST, arahkan kembali ke halaman login
    header("Location: login.php");
    exit();
}
?>