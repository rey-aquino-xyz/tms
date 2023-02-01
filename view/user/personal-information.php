<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$User = UserController::GetByContact($_SESSION['contact']);

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h2>Personal Information</h2>
</div>
<form class="row g-3" name="resident-registration-form">

    <div class="col-md-6">
        <label for="inputName" class="form-label fw-bold">Name</label>
        <input type="text" class="form-control" id="inputName" value="<?=$User->Name?>" placeholder="Juan Dela Cruz Jr. II" name="r_name" disabled>
    </div>
    <div class="col-md-6">
        <label for="inputPhone" class="form-label fw-bold">Email</label>
        <input type="tel" class="form-control" id="inputPhone" value="<?=$User->Contact?>" required disabled>
    </div>

    <div class="col-md-12">
        <label for="inputBarangay" class="form-label fw-bold">Barangay</label>
        <input type="tel" class="form-control" id="inputBarangay" value="<?=BarangayController::GetById($User->BarangayId)->Name?>" disabled>
    </div>

    <div class="col-md-12">
        <label for="inputMunicipality" class="form-label fw-bold">Municipality</label>
        <input type="tel" class="form-control" id="inputMunicipality" value="<?=MunicipalityController::GetById($User->MunicipalityId)->Name?>" disabled>
    </div>

    <div class="col-md-12">
        <label for="inputProvince" class="form-label fw-bold">Province</label>
        <input type="tel" class="form-control" id="inputProvince" value="<?=ProvinceController::GetById($User->ProvinceId)->Name?>" disabled>
    </div>

    <!-- <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2">Save Taxpayer Information</button>
    </div> -->

</form>