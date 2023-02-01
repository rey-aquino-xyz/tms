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


    <!-- SWEET ALERT -->
    <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

    <title>DARPTMS</title>
    <style>
        html,
        body {
            height: 100%;
            font-family: 'Work Sans', sans-serif;

        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            max-width: 330px;
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

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../assets/images/loader.gif') 50% 50% no-repeat rgb(249,249,249);


        }

        .loader:before {
            content: attr(data-wordLoad);
            color: #12100f;
            position: absolute;
            top: calc(45% + 100px);
            /* gif圖片的高度一半 */
            left: calc(50% - 90px);
            /* 設定文字寬度的 一半 */
            width: 200px;
            display: table-cell;
            text-align: center;
            vertical-align: middle;
            font-size: 1rem;
        }
    </style>

    <script>
        $(document).ready(function () {

            $('[name="recovery-form"]').on('submit', function (e) {
                e.preventDefault();
                $("#loader").attr("style", "display:block");
                var email = $("#inputEmail");
                $.post('account-recovery-process.php', { c_email: email.val() }, function (result) {
                    if (result.trim() == 't') {
                        $("#loader").attr("style", "display:none");
                        $("#account-recovery-content").load('account-verify-otp.php', { email: email.val() });
                    } else {
                        $("#loader").attr("style", "display:none");
                        $("#account-recovery-content").load('account-verify-otp.php');
                    }
                });

            })

        });
    </script>
</head>

<body class="text-center">

    <div class="loader" id="loader" data-wordLoad="Please wait. . ." style="display: none;"></div>

    <main class="form-signin w-100 m-auto">
        <div id="account-recovery-content">
            <form name="recovery-form">
                <a href="/tms/">
                    <img class="mb-4" src="../../assets/images/da-e.png" alt="" width="100" height="100">
                </a>

                <h1 class="h3 fw-normal">Account Recovery
                </h1>
                <h6>Property Tax Monitoring System</h6>
                <br>

                <div class="input-group input-group-md mb-3">
                    <span class="input-group-text" id="addon-wrapping">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-envelope-fill" viewBox="0 0 16 16">
                            <path
                                d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                        </svg>
                    </span>
                    <input type="text" id="inputEmail" class="form-control" placeholder="Email" aria-label="Phone No."
                        aria-describedby="addon-wrapping" required>
                </div>

                <button class="w-100 btn btn-md btn-primary mb-2" type="submit">Confirm Email</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2022–2023</p>
            </form>
        </div>
    </main>



</body>

</html>