<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'Pemuda_Laundri');

$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Periksa apakah koneksi berhasil
if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// query
function query($query, $connect)
{
    $result = mysqli_query($connect, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function updateUser($data, $connect)
{
    $id = $data["user_id"];
    $result = query("SELECT password FROM user WHERE user_id = $id", $connect)[0];
    $username = $data["username"];

    // Check if the password field is empty or not provided
    if (empty($data["password"])) {
        $password = $result["password"];
    } else {
        $password = password_hash($data["password"], PASSWORD_DEFAULT);
    }

    // Include the $email variable from the form data
    $query = "UPDATE user SET
                username = '$username',
                password = '$password'
              WHERE user_id = $id
            ";

    $result = mysqli_query($connect, $query);

    // Periksa apakah query berhasil dieksekusi
    if (!$result) {
        die("Error query: " . mysqli_error($connect));
    }

    return mysqli_affected_rows($connect);
}
?>