<?php
include_once __DIR__ . '../../../config.php';

$TDN = '';
if (isset($_POST['tdn'])) {
$TDN = TDNController::GetByPIN($_POST['tdn']);
}

?>
<script>
    $(document).ready(function () {
        // $('[name="pin-information-link"]').on('click', function (e) {
        //     e.preventDefault();
        //     var tdn = $("#inputOldTDN").val();
        //     $("#main-content").load('view-tdn-information.php', { tdn_id: tdn });
        // });

        $('[name="cancel-link"]').on('click', function (e) {
            e.preventDefault();
            var tdn = $("#inputOldTDN").val();
            $("#main-content").load('view-user-transaction.php', { userid: '<?=$TDN->UserId?>' });
        });
        $('[name="edit-tdn-form"]').on('submit', function (e) {
            e.preventDefault();
            var new_tdn = $("#inputNewTDN");
            $.post('add-tdn-process.php', { v_tdn: new_tdn.val() }, function (result) {
                console.log(result.trim());
                if (result.trim() == 't') {
                    //HAS DUPLICATE
                    new_tdn.addClass('is-invalid');
                } else {
                    //UPDATE
                    $.post('add-tdn-process.php', { update_tdn_pin: 'POST', tdnid: '<?=$TDN->TDNId?>', pin: new_tdn.val() }, function (result) {
                        console.log(result);
                        if (result.trim() == 't') {
                            swal("Update Successfull", "Tax Declaration Information updated", "success", { button: false });
                            $("#main-content").load('view-user-transaction.php', { userid: '<?=$TDN->UserId?>' });
                        } else {
                            swal("Update Failed", "Something went wrong, Please try again later.", "error", { button: false });
                        }

                    });
                }
            });
        });
    });
</script>

<form action="" name="edit-tdn-form" class="row g-3">
    <div class="col-md-6">
        <label for="inputOldTDN" class="form-label fw-bold">Old PIN No./Tax Declaration No.<span
                class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputOldTDN" value="<?=$TDN->Pin?>" name="r_old_tdn" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputNewTDN" class="form-label fw-bold">New PIN No./Tax Declaration No.<span
                class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputNewTDN" value="" name="r_new_tdn" required>
        <div class="invalid-feedback">
            PIN/ Tax Dec. Number Already Registered
        </div>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2 me-2">Update TDN Information</button>
        <button class="btn btn-secondary btn-md mb-3 mt-2" name="cancel-link">Cancel</button>
    </div>
</form>