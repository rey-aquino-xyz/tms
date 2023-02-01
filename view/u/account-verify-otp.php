<?php

$Email = '';
if (isset($_POST['email'])) {
    $Email = $_POST['email'];
}
?>
<script>
    $(document).ready(function () {
        $('[name="confirm-otp-form"]').on('submit', function (e) {
            e.preventDefault();
            $("#loader").attr("style", "display:block");
            var otp = $("#inputOTP");
            $.post('account-recovery-process.php', { c_otp: otp.val(), email: '<?=$Email?>' }, function (result) {
                if (result.trim() == 't') {
                    $("#loader").attr("style", "display:none");
                    swal("Account Recovery Successfull", "We've sent temporary password to your email", "success", { button: false });
                    setTimeout(function () {
                        window.location.replace("account-login.php");
                    }, 5000);
                } else {
                    $("#loader").attr("style", "display:none");
                    otp.addClass('is-invalid');
                }
            });
        });

    });
</script>
<div class="loader" id="loader" data-wordLoad="Verifying OTP" style="display: none;"></div>
<form name="confirm-otp-form">
    <a href="/tms/">
        <img class="mb-4" src="../../assets/images/da-e.png" alt="" width="100" height="100">
    </a>

    <h1 class="h3 fw-normal">Verify OTP</h1>
    <h6>Property Tax Monitoring System</h6>
    <h6>Please enter OTP Code below</h6>
    <br>

    <div class="input-group input-group-md mb-3">
        <span class="input-group-text" id="addon-wrapping">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-123"
                viewBox="0 0 16 16">
                <path
                    d="M2.873 11.297V4.142H1.699L0 5.379v1.137l1.64-1.18h.06v5.961h1.174Zm3.213-5.09v-.063c0-.618.44-1.169 1.196-1.169.676 0 1.174.44 1.174 1.106 0 .624-.42 1.101-.807 1.526L4.99 10.553v.744h4.78v-.99H6.643v-.069L8.41 8.252c.65-.724 1.237-1.332 1.237-2.27C9.646 4.849 8.723 4 7.308 4c-1.573 0-2.36 1.064-2.36 2.15v.057h1.138Zm6.559 1.883h.786c.823 0 1.374.481 1.379 1.179.01.707-.55 1.216-1.421 1.21-.77-.005-1.326-.419-1.379-.953h-1.095c.042 1.053.938 1.918 2.464 1.918 1.478 0 2.642-.839 2.62-2.144-.02-1.143-.922-1.651-1.551-1.714v-.063c.535-.09 1.347-.66 1.326-1.678-.026-1.053-.933-1.855-2.359-1.845-1.5.005-2.317.88-2.348 1.898h1.116c.032-.498.498-.944 1.206-.944.703 0 1.206.435 1.206 1.07.005.64-.504 1.106-1.2 1.106h-.75v.96Z" />
            </svg>
        </span>
        <input type="text" class="form-control" id="inputOTP" placeholder="Enter OTP" aria-describedby="addon-wrapping"
            required>
        <div class="invalid-feedback">
            Invalid Code
        </div>
    </div>

    <button class="w-100 btn btn-md btn-primary mb-2" type="submit">Confirm OTP Code</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2022–2023</p>
</form>