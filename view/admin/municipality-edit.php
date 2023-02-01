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

        document.getElementById("selectProvince").value = '<?=$Municipality->ProvinceId?>';

        $('[name="municipality-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('municipality.php');
        });


        $('[name="edit-form"]').on('submit', function (e) {
            e.preventDefault();
            var name = $("#inputName");
            var province_id = $("#selectProvince");

            document.getElementById("inputName").disabled = false;
            //CHECK FOR DUPLICATE
            $.post('municipality-process.php', { u_municipality: name.val(), province_id: province_id.val(), id: '<?=$Municipality->MunicipalityId?>' }, function (result) {
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
        });

        $('[name="edit-name-link"]').on('click', function (e) {
            e.preventDefault();
            $("#edit-content").load('municipality-edit-name.php', { id: '<?=$Municipality->MunicipalityId?>' });
        });
    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="municipality-link"
                        class="text-decoration-none">Municipality</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Municipality Information</li>
            </ol>
        </nav>
    </h2>
</div>

<div id="edit-content">
    <form action="" class="row g-3" name="edit-form">
        <div class="col-md-6">
            <label for="inputName" class="form-label">Municipality</label>
            <input type="text" class="form-control" id="inputName" value="<?=$Municipality->Name?>" disabled required>
            <div class="invalid-feedback">
                Municipality Already Registered
            </div>
        </div>
        <div class="col-md-6">
            <label for="selectProvince" class="form-label">Province</label>
            <select id="selectProvince" class="form-select" required>
                <?php foreach (ProvinceController::Get() as $r): ?>
                <option value="<?=$r['province_id']?>">
                    <?=strtoupper($r['name'])?>
                </option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary btn-md">Save Municipality</button>
            <button name="edit-name-link" class="btn btn-primary btn-md ms-2">Change Municipality Name</button>
        </div>
    </form>
</div>