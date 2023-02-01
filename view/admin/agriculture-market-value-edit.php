<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$AgriMarketValInfo = '';
if (isset($_POST['id'])) {
    $AgriMarketValInfo = AgriMarketValueController::GetById($_POST['id']);
}
?>
<script>
    $(document).ready(function () {

        document.getElementById("selectLands").value = '<?=$AgriMarketValInfo->AgriSubClassId?>';

        $('[name="market-value-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('agriculture-market-value.php');
        });
        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'agriculture-market-value-process.php',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.trim() == 't') {
                        swal("Market Value Updated Successfully", "information has been updated successfully", "success", { button: false });
                        setTimeout(function () {
                            $("#main-content").load('agriculture-market-value.php');
                        }, 1000);
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
                <li class="breadcrumb-item"><a href="#" name="market-value-link" class="text-decoration-none">Market
                        Value</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Market Value</li>
            </ol>
        </nav>
    </h2>
</div>

<form action="agriculture-market-value-process.php" class="row g-3" method="post" name="add-form">
    <input type="hidden" name="e_id" value="<?=$AgriMarketValInfo->AgriMarketValueId?>">
    <div class="col-md-12">
        <label for="selectLands" class="form-label">LANDS</label>
        <select id="selectLands" name="e_lands" class="form-select" required>
            <?php foreach (AgriSubClassController::Get() as $r): ?>
            <option value="<?=$r['agri_sub_class_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="input1st" class="form-label">1ST</label>
        <input type="number" class="form-control" id="input1st" value="<?=$AgriMarketValInfo->First?>" name="e_1st">
    </div>
    <div class="col-md-6">
        <label for="input2nd" class="form-label">2ND</label>
        <input type="number" class="form-control" id="input2nd" value="<?=$AgriMarketValInfo->Second?>" name="e_2nd">
    </div>

    <div class="col-md-6">
        <label for="input3rd" class="form-label">3RD</label>
        <input type="number" class="form-control" id="input3rd" value="<?=$AgriMarketValInfo->Third?>" name="e_3rd">
    </div>
    <div class="col-md-6">
        <label for="input4th" class="form-label">4TH</label>
        <input type="number" class="form-control" id="input4th" value="<?=$AgriMarketValInfo->Fourth?>" name="e_4th">
    </div>

    <div class="col-md-6">
        <label for="input5th" class="form-label">5TH</label>
        <input type="number" class="form-control" id="input5th" value="<?=$AgriMarketValInfo->Fifth?>" name="e_5th">
    </div>
    <div class="col-md-6">
        <label for="input6th" class="form-label">6TH</label>
        <input type="number" class="form-control" id="input6th" value="<?=$AgriMarketValInfo->Sixth?>" name="e_6th">
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Market Value</button>
    </div>
</form>