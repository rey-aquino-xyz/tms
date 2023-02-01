<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$User           = '';
$TDNInformation = '';

if (isset($_POST['tdn_id'])) {
    $TDNInformation = TDNController::GetById($_POST['tdn_id']);
    $User           = UserController::GetByUserId($TDNInformation->UserId);
}

?>

<script>
    $(document).ready(function () {
        document.getElementById("selectClassification").value = "<?php echo $TDNInformation->ClassificationId ?>";

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('view-user.php');
        });
        $('[name="user-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('view-user-transaction.php', { userid: '<?=$User->UserId?>' });
        });

        $('[name="edit-tdn-form"]').on('submit', function (e) {
            e.preventDefault();
            document.getElementById("inputTDN").disabled = false;

            var pin = $('#inputTDN');
            var classification = $('#selectClassification');
            var location = $('#inputLocation');
            $.post('add-tdn-process.php', { update_tdn: 'POST', pin: pin.val(), classification: classification.val(), location: location.val(), tdnid: '<?=$TDNInformation->TDNId?>' }, function (result) {
                console.log(result);
                if (result.trim() == 't') {
                    document.getElementById("inputTDN").disabled = true;
                    swal("Update Successfull", "Tax Declaration Information updated", "success", { button: false });
                } else {
                    swal("Update Failed", "Something went wrong, Please try again later.", "error", { button: false });
                }
            });

        });
        $('[name="change-pin-link"]').on('click', function(e){
            e.preventDefault();
            var pin = $('#inputTDN');
            $("#tdn-information-content").load('edit-tdn.php', {tdn: pin.val()});
        });
    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item"><a href="#" name="user-link"
                        class="text-decoration-none"><?=$User->Name?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?=$TDNInformation->Pin?></li>
            </ol>
        </nav>
    </h2>
</div>

<div id="tdn-information-content">
<form action="" name="edit-tdn-form" class="row g-3">
    <h6>PIN No. / Tax Declaration No. Information</h6>
    <div class="col-md-6">
        <label for="inputTDN" class="form-label fw-bold">PIN No./Tax Declaration No.<span
                class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputTDN" value="<?=$TDNInformation->Pin?>" name="r_tdn" disabled>
        <div class="invalid-feedback">
            PIN/ Tax Dec. Number Already Registered
        </div>
    </div>
    <div class="col-md-6">
        <label for="selectClassification" class="form-label fw-bold">Classification</label>
        <select id="selectClassification" class="form-select" name="r_classification" required>
            <option value="<?=Enum_TDN_Classification::Residential()?>">Residential</option>
            <option value="<?=Enum_TDN_Classification::Agricultural()?>">Agricultural</option>
            <option value="<?=Enum_TDN_Classification::Commercial()?>">Commercial</option>
            <option value="<?=Enum_TDN_Classification::Industrial()?>">Industrial</option>
            <option value="<?=Enum_TDN_Classification::Mineral()?>">Mineral</option>
            <option value="<?=Enum_TDN_Classification::Timber()?>">Timber</option>
            <option value="<?=Enum_TDN_Classification::Hospital()?>">Hospital</option>
            <option value="<?=Enum_TDN_Classification::Machineries()?>">Machineries</option>
            <option value="<?=Enum_TDN_Classification::Recreation()?>">Recreation</option>
            <option value="<?=Enum_TDN_Classification::Scientific()?>">Scientific</option>
            <option value="<?=Enum_TDN_Classification::Cultural()?>">Cultural</option>
            <option value="<?=Enum_TDN_Classification::Others()?>">Others</option>
        </select>
    </div>

    <div class="col-md-12">
        <label for="inputLocation" class="form-label fw-bold">Location<span
                class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputLocation" value="<?=$TDNInformation->Location?>"
            name="r_location" required>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2 me-2">Save Information</button>
        <button class="btn btn-primary btn-md mb-3 mt-2" name="change-pin-link">Change PIN/Tax Dec. Number</button>
    </div>
</form>
</div>

<hr>
<h6>Assessed Value History</h6>
<div class="table-responsive">
    <table class="table table-striped" name="sampple-tbl">
        <thead>
            <tr>
                <th scope="col">Assessed Value</th>
                <th scope="col">Year</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>30,480.00</td>
                <td>2022</td>
                <td>
                    <div class="d-flex">
                        <a href="<?=$r['user_id']?>" name="edit-info-link" class="me-3 text-decoration-none">Edit
                            Information</a>
                        <a href="<?=$r['user_id']?>" name="view-transction-link" class="text-decoration-none">View
                            Account</a>
                    </div>
                </td>
            </tr>

        </tbody>
    </table>
</div>