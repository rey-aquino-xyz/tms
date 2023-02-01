<script>
    $(document).ready(function(){


        $('[name="change-password-form"]').on('submit', function(e){
            e.preventDefault();
            var new_pwd = $("#inputPassword");
            $.post('account-verify-email-process.php',{u_password: new_pwd.val()}, function(result){
                if(result.trim() == 't'){
                    //PASSWORDUPDATED
                    swal("Password Updated", "Your password has been updated", "success", { button: false });
                    $("#main-content").load('account-information.php');
                }else{
                    swal("Somethig Went Wrong", "Please try again later", "error", { button: false });
                }
            });
        })
        $('[name="cancel-link"]').on('click',function(e){
            e.preventDefault();
            $("#main-content").load('account-information.php');
        });
    });
</script>
Please enter your new Password
<form action="" name="change-password-form">
    <div class="col-md-6">
        <label for="inputPassword" class="form-label fw-bold">Enter New Password</label>
        <input type="password" class="form-control" id="inputPassword" required>
    </div>

    <div class="d-flex">
        <button type="submit" name="update-password-link" class="btn btn-primary btn-md mb-3 mt-2">Update Password</button>
        <button name="cancel-link" class="btn btn-secondary btn-md mb-3 mt-2 ms-2">Cancel</button>
    </div>

</form>