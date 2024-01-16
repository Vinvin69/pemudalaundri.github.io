<?php
include "config.php";

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $nama_pelanggan = $_POST["nama_pelanggan"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    // Set role as 'user' for new registrations
    $role = 'user';

    $insertQuery = "INSERT INTO pembeli (username, nama_pelanggan, jenis_kelamin, telp, alamat, password, role) 
                    VALUES ('$username', '$nama_pelanggan', '$jenis_kelamin', '$telp', '$alamat', '$password', '$role')";
    $insertResult = mysqli_query($connect, $insertQuery);

    if ($insertResult) {
        $_SESSION['login_success'] = "Registrasi berhasil! Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $error = true;
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>

     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;
            /* Menyamakan lebar input, select, dan textarea */
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            appearance: none;
        }

        button {
            width: 100%;
            /* Menyamakan panjang tombol dengan input */
            background-color: #2196F3;
            color: #fff;
            padding: 10px 0;
            /* Memberikan padding atas dan bawah untuk tombol */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
        }

        button:hover {
            background-color: #1565C0;
            /* Warna biru lebih tua saat dihover */
        }
    </style>
    <script>
        // Script untuk menampilkan alert selama 2 detik
        setTimeout(function () {
            var successAlert = document.getElementById("successAlert");
            if (successAlert) {
                successAlert.style.display = "none";
            }
        }, 000);
    </script>
</head>

<body class="full-blue no-scroll">

    <?php if (isset($error)): ?>
        <div id="errorAlert" class="alert alert-danger w-75 mx-auto mt-4">
            <p class="font-weight-bold m-0 text-center">Maaf, terjadi kesalahan saat registrasi</p>
        </div>
        <script>
            setTimeout(function () {
                document.getElementById("errorAlert").style.display = "none";
            }, 3000); // Waktu dalam milidetik (3 detik)
        </script>
    <?php endif; ?>
    <?php if (isset($_SESSION['login_success'])): ?>
        <!-- ... Bagian alert untuk sukses login tetap sama ... -->
    <?php endif; ?>


                            <form method="post" action="">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typeUsername">Username</label>
                                    <input type="text" id="typeUsername" class="form-control form-control-lg"
                                        name="username" />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typePassword">Password</label>
                                    <input type="password" id="typePassword" class="form-control form-control-lg"
                                        name="password" />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typeName">Nama Pelanggan</label>
                                    <input type="text" id="typeName" class="form-control form-control-lg"
                                        name="nama_pelanggan" />
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typeGender">Jenis Kelamin</label>
                                    <select class="form-select form-select-lg" name="jenis_kelamin">
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>

                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typePhoneNumber">Nomor Telepon</label>
                                    <input type="text" id="typePhoneNumber" class="form-control form-control-lg"
                                        name="telp" inputmode="numeric" pattern="[0-9]*" title="Masukkan hanya angka" />
                                </div>


                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typeAddress">Alamat</label>
                                    <textarea class="form-control form-control-lg" id="typeAddress" name="alamat"
                                        rows="3"></textarea>
                                </div>

                                <button class="btn btn-primary btn-lg btn-block" type="submit"
                                    name="register">Simpan</button>
                            </form>

</body>

</html>