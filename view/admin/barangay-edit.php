<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$Barangay = '';
if (isset($_POST['id'])) {
    $Barangay = BarangayController::GetById($_POST['id']);
}
?>

<script>
    $(document).ready(function () {

        document.getElementById("selectMunicipality").value = '<?=$Barangay->MunicipalityId?>';

        $('[name="barangay-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('barangay.php');
        });


        $('[name="edit-form"]').on('submit', function (e) {
            e.preventDefault();
            var name = $("#inputName");
            var municipality = $("#selectMunicipality");

            $.post('barangay-process.php', { c_barangay: name.val(), municipality_id: municipality.val() }, function (result) {
                if (result.trim() == 't') {
                    name.addClass('is-invalid');
                } else {
                    //REGISTER
                    $.post('barangay-process.php', { u_barangay: name.val(), municipality_id: municipality.val(), id: '<?=$Barangay->BarangayId?>' }, function (result) {
                        if (result.trim() == 't') {
                            //SUCCESS
                            swal("Update Successfull", "barangay information has been updated", "success", { button: false });
                            setTimeout(function () {
                                $("#main-content").load('barangay.php');
                            }, 1000);
                        } else {
                            //ERROR
                            name.remove('is-invalid');
                            swal("Something Went Wrong", "Please try again later", "error", { button: false });
                        }
                    });
                }
            });
        });

        $('[name="edit-name-link"]').on('click', function (e) {
            e.preventDefault();
            $("#edit-content").load('barangay-edit-name.php', { id: '<?=$Barangay->BarangayId?>' });
        });
    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="barangay-link" class="text-decoration-none">Barangay</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Barangay Information</li>
            </ol>
        </nav>
    </h2>
</div>

<div id="edit-content">
    <form action="" class="row g-3" name="edit-form">
        <div class="col-md-6">
            <label for="inputName" class="form-label">Barangay</label>
            <input type="text" class="form-control" id="inputName" value="<?=$Barangay->Name?>" required>
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
            <!-- <button name="edit-name-link" class="btn btn-primary btn-md ms-2">Change Barangay Name</button> -->
        </div>
    </form>
</div>