<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
AccountController::SeedTempAdminAccount();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Property Tax Monitoring System</title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AJAX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
        integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Work Sans', sans-serif;
            font-size: .875rem;
        }
    </style>

    <script>
        $(document).ready(function () {

            $("#content-main").load('view/home/home.php');

        });
    </script>

</head>

<body>

    <!-- Navbar -->
    <header class="site-header sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/tms/">
                    <img src="assets/images/da.png" width="32" height="32" alt="">
                    DA-Real Property Tax Monitoring System
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor03"
                    aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor03">
                    <ul class="navbar-nav me-auto">
                        <!-- <li class="nav-item">
                            <a class="nav-link active" href="#">Home
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">Transactions</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">{ }</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li> -->
                    </ul>
                    <div class="d-flex align-items-center">
                        <?php if (isset($_SESSION['contact'])): ?>
                        <a href="/tms/view/u/account-redirect.php" id="profile-link"
                            class="text-decoration-none btn btn-md btn-primary">
                            <?=UserController::GetByContact($_SESSION['contact'])->Name?>
                        </a>
                        <?php else: ?>
                        <a href="view/u/account-login.php" id="login-link"
                            class="text-decoration-none btn btn-md btn-primary">Login Account
                        </a>
                        <?php endif;?>
                    </div>

                </div>

            </div>
        </nav>
    </header>