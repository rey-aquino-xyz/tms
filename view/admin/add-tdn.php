<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$User = '';
if (isset($_POST['userid'])) {
    $User = UserController::GetByUserId($_POST['userid']);
}

?>

<script>
    $(document).ready(function () {

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('users.php');
        });

        $('[name="user-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('view-user-transaction.php', { userid: '<?=$User->UserId?>' });
        });

        $('[name="register-tdn-form"]').on('submit', function (e) {
            e.preventDefault();
            var pin = $('#inputTDN');
            var classification = $('#selectClassification');
            var location = $('#inputLocation');

            //CHECK IF PIN EXIST
            $.post('add-tdn-process.php', { v_tdn: pin.val() }, function (result) {
                if (result.trim() == 't') {
                    //PIN IS EXISTNG
                    pin.addClass('is-invalid');
                } else {
                    //REGISTER
                    $.post('add-tdn-process.php', { register_tdn: 'POST', pin: pin.val(), classification: classification.val(), location: location.val(), userid: '<?=$User->UserId?>' }, function (result) {
                        console.log(result);
                        if (result.trim() == 't') {
                                swal("Registered Successfully", "You can register another one", "success", { button: false });
                                $('[name="register-tdn-form"]')[0].reset();
                                pin.removeClass('is-invalid');
                            }else{
                                swal("Registration Failed", "Something went wrong, Please try again later.", "error", { button: false });
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
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item"><a href="#" name="user-link"
                        class="text-decoration-none"><?=$User->Name?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Tax Dec. No.</li>
            </ol>
        </nav>
    </h2>
</div>

<form action="" name="register-tdn-form" class="row g-3">
    <h4 class="p-2 bg-primary text-light rounded">PIN No./Tax Declartion No.</h4>
    <div class="col-md-6">
        <label for="inputTDN" class="form-label fw-bold">PIN No./Tax Declaration No. Information<span
                class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputTDN" name="r_tdn" required>
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
        <input type="text" class="form-control" id="inputLocation" name="r_location" required>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2">Save TDN Information</button>
    </div>
</form>
<!-- <hr>
<h4 class="p-2 bg-primary text-light rounded">Assessed Value History</h4>
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
                        <a href="<?=$r['user_id']?>" name="edit-info-link" class="me-3 text-decoration-none">Edit Information</a>
                        <a href="<?=$r['user_id']?>" name="view-transction-link" class="text-decoration-none">View Account</a>
                    </div>
                </td>
            </tr>
         
        </tbody>
    </table>
</div> -->