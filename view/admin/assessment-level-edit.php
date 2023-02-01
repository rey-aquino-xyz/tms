<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$Info = '';
if (isset($_POST['id'])) {
    $Info = AssessmentLevelController::GetByClass($_POST['id']);
}
?>

<script>
    $(document).ready(function () {
        $('[name="assessment-level-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('assessment-level.php');
        });

        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var class_id = '<?=$Info->ClassificationId?>';
            var value = $("#inputValue");

            $.post('assessment-level-process.php', { u_class: class_id, value: value.val() }, function (result) {
                if (result.trim() == 't') {
                    swal("Updated Successfully", "Assessment level value has been updated", "success", { button: false });
                    $("#main-content").load('assessment-level.php');
                } else {
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
                <li class="breadcrumb-item"><a href="#" name="assessment-level-link"
                        class="text-decoration-none">Assessment Level</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add Assessment Level</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-6">
        <label for="inputClass" class="form-label">Class</label>
        <input type="text" class="form-control" id="inputClass"
            value="<?=Enum_Property_Classification::GetStringName($Info->ClassificationId)?>" disabled required>
    </div>
    <div class="col-md-6">
        <label for="inputValue" class="form-label">Assessment Level (Percent)</label>
        <input type="number" class="form-control" id="inputValue" value="<?=$Info->Value?>" required>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Update Assessment Value</button>
    </div>
</form>