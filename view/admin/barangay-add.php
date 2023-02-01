<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
?>

<script>
    $(document).ready(function () {

        $('[name="barangay-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('barangay.php');
        });


        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var name = $("#inputName");
            var municipality = $("#selectMunicipality");
            //CHECK FOR DUPLICATE
            $.post('barangay-process.php', { c_barangay: name.val(), municipality_id: municipality.val() }, function (result) {
                if (result.trim() == 't') {
                    name.addClass('is-invalid');
                } else {
                    //REGISTER
                    $.post('barangay-process.php', { a_barangay: name.val(), municipality_id: municipality.val() }, function (result) {
                        if (result.trim() == 't') {
                            //SUCCESS
                            name.removeClass('is-invalid');
                            swal("Registered Successfully", "You can register another one", "success", { button: false });
                            $('[name="add-form"]')[0].reset();
                        } else {
                            //ERROR
                            name.remove('is-invalid');
                            swal("Something Went Wrong", "Please try again later", "error", { button: false });
                        }
                    });
                }
            });


        });
    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="barangay-link" class="text-decoration-none">Barangay</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add New Barangay</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-6">
        <label for="inputName" class="form-label">Barangay</label>
        <input type="text" class="form-control" id="inputName" required>
        <div class="invalid-feedback">
            Barangay already registered at the same municipality
        </div>
    </div>
    <div class="col-md-6">
        <label for="selectMunicipality" class="form-label">Municipality</label>
        <select id="selectMunicipality" class="form-select" required>
            <?php foreach (MunicipalityController::Get() as $r): ?>
            <option value="<?=$r['municipality_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Barangay</button>
    </div>
</form>