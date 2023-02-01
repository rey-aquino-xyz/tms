
<script>
    $(document).ready(function(){

        $('[name="change-email-form"]').on('submit', function(e){
            e.preventDefault();
            var new_email = $('#inputEmail');

            //CHECKING FOR DUPLICATE EMAIL
            $.post('account-verify-email-process.php', {c_email : new_email.val()},function(result){
                if(result.trim() == 't'){
                    //ERROR EMAIL EXIST
                    new_email.addClass('is-invalid');
                }else{
                    //UPDATE EMAIL
                    $.post('account-verify-email-process.php', {u_email : new_email.val()}, function(result){
                        if(result.trim() == 't'){
                            //EMAIL UPDATED
                            swal("Email Updated", "Your email has been updated", "success", { button: false });
                            $("#main-content").load('account-information.php');
                        }else{
                            swal("Something Went Wrong", "Please try again later", "error", { button: false });
                        }
                    });
                }
            });
        });


        $('[name="cancel-link"]').on('click',function(e){
            e.preventDefault();
            $("#main-content").load('account-information.php');
        });
    });
</script>

Please enter your new email address
<form action="" name="change-email-form">
    <div class="col-md-6">
        <label for="inputEmail" class="form-label fw-bold">Enter New Email</label>
        <input type="email" class="form-control" id="inputEmail" required>
        <div class="invalid-feedback">
            Email Already Exist
        </div>
    </div>

    <div class="d-flex">
        <button type="submit" name="verify-code-link" class="btn btn-primary btn-md mb-3 mt-2">Update Email</button>
        <button type="" name="cancel-link" class="btn btn-secondary btn-md mb-3 mt-2 ms-2">Cancel</button>
    </div>

</form>