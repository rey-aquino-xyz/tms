<?php
ob_start();
session_start();
include_once 'config.php';
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>

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

        .hero-content {
            position: relative;
            text-align: left;
            color: white;
        }

        .hero-text {
            position: absolute;
            top: 40%;
            left: 10%;
        }

        .avatar {
            vertical-align: middle;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .image-cropper {
            width: 50px;
            height: 50px;
            position: relative;
            overflow: hidden;
            border-radius: 50%;
        }

        .profile-pic {
            display: inline;
            margin: 0 auto;
            margin-left: 0;
            height: 100%;
            width: auto;
        }

        .dropdown-toggle-post::after {
            content: none;
        }

        .xcontainer {
            position: relative;
            /* max-width: 800px; */
            /* Maximum width */
            margin: 0 auto;
            /* Center it */
        }

        .xcontainer .xcontent {
            position: absolute;
            /* Position the background text */
            bottom: 0;
            /* At the bottom. Use top:0 to append it to the top */
            background: rgb(0, 0, 0);
            /* Fallback color */
            background: rgba(0, 0, 0, 0.5);
            /* Black background with 0.5 opacity */
            color: #f1f1f1;
            /* Grey text */
            width: 100%;
            /* Full width */
            padding: 20px;
            /* Some padding */
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <header class="site-header sticky-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/tms/">
                    <img src="assets/images/da.png" width="32" height="32" alt="">
                    Real Property Tax Monitoring System
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

    <div class="hero-content">
        <img src="assets/images/bg0.jpg" height="300px" width="100%" />
        <div class="hero-text">
            <h2>Real Property Tax</h2>
            <p>How to pay your Real Property Tax?</p>
        </div>
    </div>
    <!-- <div class="xcontainer">
    <img src="public/assets/bg.webp" width="100%" alt="">
    <div class="xcontent">
        <h1>HOW TO PAY YOUR <br> REAL PROPERTY TAX</h1>
    </div>
</div> -->
    <br><br>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold card-title">For Current Taxpayers</h4>
                <hr>
                <h6 class="fw-bold">[ Requirements ]</h6>
                <p>Previous Year Official Receipt</p>
                <h6 class="fw-bold">[ Steps ]</h6>
                <p>Go to Assessment Clerk and present your previous year’s official receipt to get your current
                    assessment
                </p>
                <p>Proceed to the payment window</p>
            </div>
        </div>
        <br><br>
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="fw-bold card-title">To monitor your payments</h4>
                <hr>
                <p class="card-text"><a class="text-decoration-none" href="view/u/account-login.php">Login to your
                        account</a> or you may want to go to Assessor’s Office to create your account
                </p>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-title">
                    <h2 class="fw-bold">Frequently Asked Questions(FAQs) </h2>
                </div>
            </div>
        </div>
        <br>
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        What is Real Property Tax?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Real Property Tax (RPT) is a levy on real properties, such as land,
                        buildings, machineries and other improvements affixed or attached to real properties not
                        specifically exempted under the law. It accrues on the 1st of January and is payable in one
                        or four equal installments. RPT installment payments must be made on or before the end of
                        each quarter, making the first installment due on or before March 31.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        What is a Tax Declaration Number?
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">

                        A Tax Declaration Number is given by the City Assessor’s Office to customers once
                        registration of property under their name is approved – either new property or transfer of
                        property. This number may be easily seen in the taxpayer’s previous years’ receipts.
                        <br><br>
                        Example of Tax Declaration Number: C-022-00001
                        <br><br>
                        During assessment and payment, customer will be asked to enter their Tax Declaration Number
                        (11 alphanumeric code including the dash).
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        How will I inquire about my Real Property Tax (any info related to Real Property Tax, TDN,
                        etc.)?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Call the Municipal Treasurer’s Office { }</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                        How do I request for the details of my payment for Real Property Tax?
                    </button>
                </h2>
                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Call the Municipal Treasurer’s Office { }</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseOne">
                        Why should I have my Real Property Tax assessed first before payment?
                    </button>
                </h2>
                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">This is to ensure that you are paying the right current balance of
                        your Real Property Tax.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseTwo">
                        What are the details shown in my assessment that will validate that I inputted the right Tax
                        Declaration Number (TDN)?
                    </button>
                </h2>
                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                    data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">

                        Once the subscriber confirms assessment of his Real Property Tax, he will
                        receive the following details:
                        <br><br>
                        A. Current Quarter balance & End of year balance of his Real Property Tax
                        <br><br>
                        B. Name of Tax Payer
                        <br><br>
                        C. Due Date
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>

</body>

</html>