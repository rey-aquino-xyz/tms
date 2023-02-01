<?php
include_once __DIR__ . '../../../config.php';

$TaxpayerInfo = '';
if (isset($_POST['id'])) {
    $TaxpayerInfo = UserController::GetByUserId($_POST['id']);
}
?>

<script>
    $(document).ready(function () {

        document.getElementById("selectProvince").value = '<?=$TaxpayerInfo->ProvinceId?>';
        document.getElementById("selectMunicipality").value = '<?=$TaxpayerInfo->MunicipalityId?>';
        document.getElementById("selectBarangay").value = '<?=$TaxpayerInfo->BarangayId?>';

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers.php');
        });

        $('[name="resident-edit-form"]').on('submit', function (e) {
            e.preventDefault();
            document.getElementById("inputPhone").disabled = false;
            var form = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'taxpayers-process.php',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.trim() == 't') {
                        swal("Information Updated Successfully", "Taxpayers information has been updated", "success", { button: false });
                        setTimeout(function () {
                            $("#main-content").load('taxpayers.php');
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
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Taxpayer Information</li>
            </ol>
        </nav>
    </h2>
</div>
<div class="loader" id="loader" data-wordLoad="Loading . . ." style="display: none;"></div>
<form class="row g-3" name="resident-edit-form">

    <h4 class="p-2 bg-primary text-light rounded">Personal Information</h4>
    <input type="hidden" name="e_id" value="<?=$TaxpayerInfo->UserId?>">
    <div class="col-md-12">
        <label for="inputName" class="form-label fw-bold">Name <span class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputName" placeholder="Juan Dela Cruz Jr. II" name="e_name"
            value="<?=strtoupper($TaxpayerInfo->Name)?>" required>
    </div>
    <div class="col-md-12">
        <label for="inputPhone" class="form-label fw-bold">Email</label>
        <input type="email" class="form-control" id="inputPhone" name="e_email" value="<?=$TaxpayerInfo->Contact?>" required disabled>
        <div class="invalid-feedback">
            Email Already Registered
        </div>
    </div>

    <div class="col-md-6">
        <label for="selectProvince" class="form-label">Province</label>
        <select id="selectProvince" class="form-select" name="e_province" required>
            <?php foreach (ProvinceController::Get() as $r): ?>
            <option value="<?=$r['province_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="selectMunicipality" class="form-label">Municipality</label>
        <select id="selectMunicipality" class="form-select" name="e_municipality" required>
            <!-- <option value="0">-- SELECT MUNICIPALITY --</option> -->
            <?php foreach (MunicipalityController::Get() as $r): ?>
            <option value="<?=$r['municipality_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="selectBarangay" class="form-label">Barangay</label>
        <select id="selectBarangay" class="form-select" name="e_barangay" required>
            <!-- <option value="0">-- SELECT BARANGAY --</option> -->
            <?php foreach (BarangayController::Get() as $r): ?>
            <option value="<?=$r['barangay_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2">Save Taxpayer Information</button>
    </div>

</form>