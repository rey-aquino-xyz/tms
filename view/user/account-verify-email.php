<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$Action = '';
if (isset($_POST['action'])) {
    $Action = $_POST['action'];
}

?>


<script>

$(document).ready(function(){

    $('[name="verify-code-form"]').on('submit', function(e){
        e.preventDefault();
        var code = $("#inputCode");
        var action = '<?=$Action?>';
        $.post('account-verify-email-process.php', {v_code : code.val(), email: '<?=$_SESSION['contact']?>'}, function(result){
            console.log(result.trim());
            if(result.trim() == 't'){
                if(action  == 'email'){
                    $("#account-content").load('account-change-email.php');
                }else{
                    $("#account-content").load('account-change-password.php');
                }
            }else{
                code.addClass('is-invalid');
            }
        });

    });
    $('[name="cancel-link"]').on('click', function(e){
        e.preventDefault();
        //REMOVE OTP VERIFICATION
        $("#main-content").load('account-information.php');
        // $.post('account-verify-email-process.php', {x_cancel: 'POST'}, function(result){
        //     if(result.trim() =='t'){
        //     }
        // });
    });
});
</script>

A 6 digit code has been sent to your email address
<form action="" name="verify-code-form">
    <div class="col-md-6">
        <label for="inputCode" class="form-label fw-bold">Enter Code</label>
        <input type="text" class="form-control" id="inputCode" required>
        <div class="invalid-feedback">
            Invalid Code
        </div>
    </div>

    <div class="d-flex">
        <button type="submit" name="verify-code-link" class="btn btn-primary btn-md mb-3 mt-2">Verify Code</button>
        <!-- <button type="" name="resend-code-link" class="btn btn-secondary btn-md mb-3 mt-2 ms-2">Resend Verification Code</button> -->
        <button type="" name="cancel-link" class="btn btn-secondary btn-md mb-3 mt-2 ms-2">Cancel</button>
    </div>

</form>