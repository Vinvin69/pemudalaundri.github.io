<?php
include "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add your CSS links here -->
    <!-- Misalnya, Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }

        .full-height {
            height: 100vh;
        }

        .full-blue {
            background-color: #508bfc;
        }

        .white-background {
            background-color: #ffffff;
        }

        .no-scroll {
            overflow: hidden;
        }
    </style>
</head>

<body class="full-blue no-scroll">

    <?php
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($connect, "SELECT * FROM pembeli WHERE username = '$username'");
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["password"])) {
                $_SESSION["login"] = true;
                $_SESSION["user"] = $row["id_pelanggan"];
                $_SESSION["username"] = $row["username"];

                // Redirect to user or admin page based on role
                if ($row["role"] == "admin") {
                    header("Location: admin/index.php");
                } elseif ($row["role"] == "user") {
                    header("Location: user/index.php");
                } else {
                    header("Location: index.php");
                }

                exit(); // Ensure that the script stops executing after the redirect
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    }
    ?>
    
    <?php if (isset($error)): ?>
        <div id="errorAlert" class="alert alert-danger w-75 mx-auto mt-4">
            <p class="font-weight-bold m-0 text-center">Maaf, username atau Password salah</p>
        </div>
        <script>
            setTimeout(function () {
                document.getElementById("errorAlert").style.display = "none";
            }, 3000); // Waktu dalam milidetik (3 detik)
        </script>
    <?php endif; ?>
    <?php if (isset($_SESSION['login_success'])): ?>
        <div class="alert alert-success w-75 mx-auto mt-4">
            <p class="font-weight-bold m-0 text-center">
                <?= $_SESSION['login_success']; ?>
            </p>
        </div>
        <?php unset($_SESSION["login_success"]) ?>
    <?php endif; ?>

    <section class="full-height d-flex justify-content-center align-items-center white-background">
        <div class="container">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Sign in</h3>

                            <form method="post" action="">
                                <div class="form-outline mb-4">
                                    <input type="text" id="typeUsername" class="form-control form-control-lg"
                                        name="username" />
                                    <label class="form-label" for="typeUsername">Username</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="typePassword" class="form-control form-control-lg"
                                        name="password" />
                                    <label class="form-label" for="typePassword">Password</label>
                                </div>

                                <!-- Checkbox -->

                                <button class="btn btn-primary btn-lg btn-block" type="submit"
                                    name="login">Login</button>


                                <hr class="my-8">

                                <a href="register.php" class="btn btn-lg btn-block btn-primary"
                                    style="background-color: #dd4b39;">Register</a>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>