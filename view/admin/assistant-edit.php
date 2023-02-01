<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$AssistantInfo = '';
if(isset($_POST['id'])){
    $AssistantInfo = AssistantController::GetById($_POST['id']);
}
?>

<script>
    $(document).ready(function () {

        $('[name="sub-class-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('assistant.php');
        });

        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var frm = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'assistant-process.php',
                data: frm,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.trim() == 't') {
                        swal("Assistant information Successfully", "Assistant information has been updated", "success", { button: false });
                        //$('[name="add-form"]')[0].reset();
                        setTimeout(function () {
                            $("#main-content").load('assistant.php');
                        }, 700);

                    } else {
                        swal("Something Went Wrong", "Please try again later", "error", { button: false });
                    }
                }
            });
        });

    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="sub-class-link" class="text-decoration-none">Office
                        Assistants</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Assistant Information</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <input type="hidden" name="e_id" value="<?=$AssistantInfo->AssistantId?>">
    <div class="col-md-12">
        <label for="inputName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputName" name="e_name" value="<?=$AssistantInfo->Name?>" required>
        <div class="invalid-feedback">
            Sub category already exist
        </div>
    </div>
    <div class="col-md-12">
        <label for="inputContact" class="form-label">Contact</label>
        <input type="number" class="form-control" id="inputContact" name="e_contact" value="<?=$AssistantInfo->Contact?>">
    </div>
    <div class="col-md-12">
        <label for="inputAddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="inputAddress" name="e_address" value="<?=$AssistantInfo->Address?>">
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Assistant</button>
    </div>
</form>
