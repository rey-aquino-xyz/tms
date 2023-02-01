<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$User = UserController::GetByContact($_SESSION['contact']);

?>

<script>
    $(document).ready(function(){
        $('[ name="change-email-link"]').on('click',function(e){
            e.preventDefault();

            $("#loader").attr("style","display:block");
            $.post('account-verify-email-process.php', {x_send : 'OTP'}, function(result){
                console.log(result);
                if(result.trim()=='t'){
                    $("#loader").attr("style","display:none");
                    $('#account-content').load('account-verify-email.php',{action : 'email'});
                }else{
                    $("#loader").attr("style","display:none");
                    swal("Something Went Wrong", "Sorry, pleasery again later", "error", { button: false });
                }
            });
        })

        $('[name="change-password-link"]').on('click', function(e){
            e.preventDefault();
            $("#loader").attr("style","display:block");
            $.post('account-verify-email-process.php', {x_send : 'OTP'}, function(result){
                console.log(result);
                if(result.trim()=='t'){
                    $("#loader").attr("style","display:none");
                    $('#account-content').load('account-verify-email.php',{action : 'pwd'});
                }else{
                    $("#loader").attr("style","display:none");
                    swal("Something Went Wrong", "Sorry, pleasery again later", "error", { button: false });
                }
            });
        });

    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Account Information</h2>
</div>


<div class="loader" id="loader" data-wordLoad="Please wait. . ." style="display: none;"></div>

<div class="row g-3">
    <div id="account-content">
        <div class="col-md-12">
            <label for="inputName" class="form-label fw-bold">Email</label>
            <input type="text" class="form-control" id="inputName" value="<?=$User->Contact?>" name="r_name" disabled>
        </div>

        <div class="d-flex">
            <button type="" name="change-email-link" class="btn btn-primary btn-md mb-3 mt-2">Change Email</button>
            <button type="" name="change-password-link" class="btn btn-primary btn-md mb-3 mt-2 ms-2">Change Password</button>
        </div>
    </div>
</div>