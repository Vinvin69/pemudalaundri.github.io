<?php
require_once '../config.php';

// Periksa apakah session sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Periksa apakah pengisian form profile.php telah selesai
if (!isset($_SESSION['is_profile_completed']) || !$_SESSION['is_profile_completed']) {
    // Jika belum, redirect ke profile.php
    header("Location: profile.php");
    exit();
}

$id = $_SESSION["username"];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    .container-fluid {
        height: 100%;
        display: flex;

    }

    #sidebar {
        display: flex;
        width: 250px;
        min-height: 100%;
        background-color: #343a40;
        flex-direction: column;
        padding-top: 56px;
        margin-right: 50px;
        flex: 0 0 auto;
    }

    main {
        flex: 1;
        padding-top: 100px;
    }

    .navbar {
        background-color: #bf1802;
        height: 56px;
    }

    .navbar-brand {
        color: white;
        font-weight: 700;
    }

    .nav-item {
        margin-bottom: 10px;
    }

    /* .nav-link {
        color: white;
    } */

    .nav-link.active {
        font-weight: 800;
    }

    .avatar {
        position: relative;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
    }

    .avatar img {
        width: 150px;
        border-radius: 50%;
        border: 5px solid #FFFFFF;
    }
</style>

<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-sm navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Pemuda Laundri</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-xl-nowrap">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky bg-dark">
                    <!-- Sidebar content goes here -->
                    <div class=avatar>
                        <img src="../pl-icon.jpg" class="img-fluid">
                    </div>

                    <ul class="nav flex-column" style="margin-top: 40px;">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="harga.php">
                                Harga
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="status.php">
                                Status
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
            </nav>

            <!-- Main content -->
            <main class="flex-grow-1">
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header">
                                    <a href="?p=input_paket">
                                        <button type="button" class="btn btn-primary">Tambah Data</button>
                                    </a>
                                </div>
                                <div class="box-body">
                                    <div class="col-md-12 col-sm-12">
                                        <div
                                            class="float-md-right w-50 p-3 mt-md-0 mt-3 ml-auto mr-0 mr-md-1 my-1 my-md-0">
                                            <form action="" method="post" class="form-inline">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="cari" autofocus
                                                        placeholder="Search for..." aria-label="Search"
                                                        aria-describedby="basic-addon2" autocomplete="off" id="keyword">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary"
                                                            type="button">Search</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                    $cari = "";
                                    if (isset($_POST['cari'])) {
                                        $cari = $_POST['cari'];
                                    }
                                    ?>
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Paket</th>
                                                <th>Nama Paket</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM paket WHERE nama_paket LIKE '%" . $cari . "%'";
                                            $no = 1;
                                            $sql = mysqli_query($connect, $query);
                                            while ($data = mysqli_fetch_array($sql)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $no++; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['kode_paket']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $data['nama_paket']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo "Rp " . number_format("$data[harga_paket]", '0', '.', '.'); ?>
                                                    </td>
                                                    <td>
                                                        <a href="index.php?p=edit_paket&kode_paket=<?php echo $data['kode_paket']; ?>"
                                                            class="btn btn-success"><i class="fa fa-edit"></i>Ubah</a>
                                                        <a href="index.php?p=hapus_paket&kode_paket=<?php echo $data["kode_paket"]; ?>"
                                                            onclick="return confirm('Anda Yakin Menghapus Data Ini');"
                                                            class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>

</body>

</html>