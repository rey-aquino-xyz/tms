<?php
include_once __DIR__ . '../../../config.php';
$Userid = '';
if (isset($_POST['userid'])) {
    $Userid = $_POST['userid'];
}
?>
<!-- AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- SWEET ALERT -->
<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

<script>
    $(document).ready(function () {

        $('[ name="update-contact-form"]').on('submit', function (e) {
            e.preventDefault();
            var contact = $("#inputNewPhone");
            var userid = $("#userid");
            $.post('add-user-process.php', { v_contact: contact.val().trim() }, function (result) {
                if (result.trim() == 't') {
                    contact.addClass('is-invalid');
                } else {
                    //UPDATE CONTACT INFO
                    $.post('edit-user-process.php', { update_contact: contact.val(), userid: userid.val() }, function (result) {
                        console.log(result.trim());
                        if (result.trim() == 't') {
                            swal("Updated Successfully", "Taxpayer Contact Information has been updated", "success", { button: false });
                            $("#main-content").load('view-user.php', { user_id: userid.val() });
                        }
                    });
                }

            });
        });

        $('[name="cancel-contact-link"]').on('click', function (e) {
            e.preventDefault();
            var userid = $("#userid");
            $("#main-content").load('view-user.php', { user_id: userid.val() });
        });
    });
</script>



<form action="" class="row g-3" name="update-contact-form">
    <div class="col-md-6">
        <label for="inputOldPhone" class="form-label fw-bold">Old Contact Number</label>
        <input type="tel" class="form-control" id="inputOldPhone"
        value="<?=UserController::GetByUserId($Userid)->Contact?>" placeholder="09xxxxxxxxxxx"
        pattern="[0-9]{4}[0-9]{7}" disabled required>
        <div class="invalid-feedback">
            Contact Number Already Registered
        </div>
    </div>
    <div class="col-md-6">
        <label for="inputNewPhone" class="form-label fw-bold">New Contact Number</label>
        <input type="tel" class="form-control" id="inputNewPhone" name="r_phone" placeholder="09xxxxxxxxxxx"
        pattern="[0-9]{4}[0-9]{7}" required>
        <div class="invalid-feedback">
            Contact Number Already Registered
        </div>
    </div>
    <div class="d-flex">
        <input type="hidden" id="userid" value="<?=$Userid?>">
        <button class="btn btn-primary btn-md me-2" type="submit" name="edit-contact-link">Update Contact
            Information</button>
        <button class="btn btn-secondary btn-md" name="cancel-contact-link">Cancel</button>
    </div>
</form>