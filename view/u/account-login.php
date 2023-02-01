<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=.8">


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


    <title>DARPTMS</title>
    <style>
        body {
            height: 100%;
            font-family: 'Work Sans', sans-serif;
            align-items: center;
            padding-top: 50px;
            padding-bottom: 50px;
            background-color: #f5f5f5; 
            /* display: flex;
            */
        }

        .bg {
            /* The image used */
            background-image: url("../../assets/images/da-municipal.jpg");

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .form-signin {
            max-width: 400px;
            padding: 15px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        /* .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        } */
    </style>

    <script>
        $(document).ready(function () {

            $('[name="login-form"]').on('submit', function (e) {
                e.preventDefault();
                var frmData = new FormData(this);
                var contact = $('[name="l_contact"]');
                var password = $('[name = "l_pwd"]');

                $.ajax({
                    url: 'account-login-process.php',
                    data: frmData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function (result) {
                        //console.log(r.trim());
                        if (result.trim() == 't') {
                            //ACCOUNT VALID
                            window.location.replace('account-redirect.php');
                        } else {
                            document.getElementById("err-alert").style.display = 'block';
                            // $('#err-alert').style.display = 'block';
                            // contact.addClass('is-invalid');
                            // password.addClass('is-invalid');
                        }
                    }
                });

                // $.post('account-login-process.php', { auth: 'POST', a_contact: contact.val(), a_pwd: password.val() }, function (result) {
                //     console.log(result);
                //     if (result.trim() == 't') {
                //         //ACCOUNT VALID
                //         window.location.replace('account-redirect.php');
                //     } else {
                //         document.getElementById("err-alert").style.display = 'block';
                //         // $('#err-alert').style.display = 'block';
                //         // contact.addClass('is-invalid');
                //         // password.addClass('is-invalid');
                //     }


                // });
            })

        });
    </script>
</head>

<?php
if(isset($_GET['err'])){
    echo '<ecript>  document.getElementById("err-alert").style.display = "block"; </script>';
}
?>
<body class="text-center bg">

    <div class="form-signin  m-auto card shadow px-4">
        <main class="">
            <form name="login-form" action="" method="post">
                <a href="../../">
                    <img class="mb-4" src="../../assets/images/da-e.png" alt="" width="100" height="100">
                </a>

                <h1 class="h3 fw-normal">Welcome Back :)
                </h1>
                <h6>Property Tax Monitoring System</h6>
                <br>
                <div class="alert alert-danger" id="err-alert" style="display: none;" role="alert">
                    Invalid Email/Password
                </div>

                <div class="input-group input-group-md  mb-1">
                    <span class="input-group-text" id="addon-wrapping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                        </svg>
                    </span>
                    <input type="email" name="l_contact" class="form-control" placeholder="Email"
                        aria-label="Email Address" aria-describedby="addon-wrapping" required>
                    <div class="invalid-feedback">
                        Invalid Email Address
                    </div>
                </div>


                <div class="input-group input-group-md">
                    <span class="input-group-text" id="addon-wrapping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-lock-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                        </svg>
                    </span>
                    <input type="password" name="l_pwd" class="form-control" placeholder="Password"
                        aria-label="Password" aria-describedby="addon-wrapping" required>
                    <div class="invalid-feedback">
                        Invalid Password
                    </div>
                </div>

                <br>

                <button class="w-100 btn btn-lg btn-primary mb-2" type="submit">Sign in</button>
                <a href="account-recovery.php">Forgot Password?</a>
                <p class="mt-5 mb-3 text-muted">&copy; 2022–2023</p>
            </form>

        </main>
    </div>
</body>

</html>