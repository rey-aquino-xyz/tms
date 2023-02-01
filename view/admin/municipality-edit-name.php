<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$Municipality = '';
if (isset($_POST['id'])) {
    $Municipality = MunicipalityController::GetById($_POST['id']);
}
?>

<script>
    $(document).ready(function () {

        document.getElementById('selectProvince').value = '<?=$Municipality->ProvinceId?>';

        $('[name="municipality-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('municipality.php');
        });


        $('[name="edit-form"]').on('submit', function (e) {
            e.preventDefault();
            document.getElementById("inputName").disabled = false;
            var name = $("#inputNewName");

            //CHECK FOR DUPLICATE
            $.post('municipality-process.php', { c_municipality: name.val() }, function (result) {

                if (result.trim() == 't') {
                    name.addClass('is-invalid');
                } else {
                    $.post('municipality-process.php', { un_municipality: name.val(), id: '<?=$Municipality->MunicipalityId?>' }, function (result) {
                        if (result.trim() == 't') {
                            //SUCCESS
                            name.removeClass('is-invalid');
                            swal("Updated Successfully", "Municipality information has been updated", "success", { button: false });
                            setTimeout(function () {
                                $("#main-content").load('municipality.php');
                            }, 2000);

                        } else {
                            //ERROR
                            name.remove('is-invalid');
                            swal("Something Went Wrong", "Please try again later", "error", { button: false });
                        }
                    });
                }
            });

        });

        $('[name="cancel-link"]').on('click', function(e){
            e.preventDefault();
            $("#main-content").load('municipality-edit.php', {id: '<?=$Municipality->MunicipalityId?>'});
        });
    });
</script>

<form action="" class="row g-3" name="edit-form">
    <div class="col-md-6">
        <label for="inputName" class="form-label">Old Name</label>
        <input type="text" class="form-control" id="inputName" value="<?=$Municipality->Name?>" disabled required>
    </div>
    <div class="col-md-6">
        <label for="selectProvince" class="form-label">Province</label>
        <select id="selectProvince" class="form-select" required disabled>
            <?php foreach(ProvinceController::Get() as $r): ?>
            <option value="<?=$r['province_id']?>"><?=strtoupper($r['name'])?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-12">
        <label for="inputNewName" class="form-label">New Name</label>
        <input type="text" class="form-control" id="inputNewName"  required>
        <div class="invalid-feedback">
            Municipality Already Registered
        </div>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Update Municipality Name</button>
        <button name="cancel-link" class="btn btn-secondary btn-md ms-2">Cancel</button>
    </div>
</form>