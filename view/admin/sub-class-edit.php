<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$Info = '';
if (isset($_POST['id'])) {
    $Info = SubClassificationController::GetById($_POST['id']);
}

?>


<script>
    $(document).ready(function () {

        $('[name="sub-class-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('sub-class.php');
        });

        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var name = $("#inputName");
            var description = $("#inputDescription");
            $.post('sub-class-process.php', { u_name: name.val(), u_description: description.val(), id: '<?=$Info->SubClassificationId?>' }, function (result) {
                if (result.trim() == 't') {
                    //
                    name.removeClass('is-invalid');
                    swal("Updated Successfully", "Sub classification information has been updated", "success", { button: false });
                } else {
                    name.removeClass('is-invalid');
                    swal("Something Went Wrong", "Please try again later", "error", { button: false });
                }
            });

        });

    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="sub-class-link" class="text-decoration-none">Sub
                        Classification</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Classification</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-12">
        <label for="inputName" class="form-label">Sub Classification</label>
        <input type="text" class="form-control" id="inputName" value="<?=$Info->Name?>" required>
        <div class="invalid-feedback">
            Sub classification already exist
        </div>
    </div>
    <div class="col-md-12">
        <label for="inputDescription" class="form-label">Description</label>
        <input type="text" class="form-control" id="inputDescription" value="<?=$Info->Description?>">
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Category</button>
    </div>
</form>