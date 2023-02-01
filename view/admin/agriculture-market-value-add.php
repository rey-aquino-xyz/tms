<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
?>
<script>
    $(document).ready(function(){

        $('[name="market-value-link"]').on('click', function(e){
            e.preventDefault();
            $("#main-content").load('agriculture-market-value.php');
        });
        $('[name="add-form"]').on('submit', function(e){
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
                        swal("Market Value Addedd Successfully", "You can add another one.", "success", { button: false });
                        $('[name="add-form"]')[0].reset();
                    }else{
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
                <li class="breadcrumb-item active" aria-current="page">Add New Market Value</li>
            </ol>
        </nav>
    </h2>
</div>

<form action="" class="row g-3" name="add-form">
    <div class="col-md-12">
        <label for="selectLands" class="form-label">LANDS</label>
        <select id="selectLands" name="lands" class="form-select" required>
            <?php foreach (AgriSubClassController::Get() as $r): ?>
            <option value="<?=$r['agri_sub_class_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="input1st" class="form-label">1ST</label>
        <input type="number" class="form-control" id="input1st" name="1st">
    </div>
    <div class="col-md-6">
        <label for="input2nd" class="form-label">2ND</label>
        <input type="number" class="form-control" id="input2nd" name="2nd">
    </div>

    <div class="col-md-6">
        <label for="input3rd" class="form-label">3RD</label>
        <input type="number" class="form-control" id="input3rd" name="3rd">
    </div>
    <div class="col-md-6">
        <label for="input4th" class="form-label">4TH</label>
        <input type="number" class="form-control" id="input4th" name="4th">
    </div>

    <div class="col-md-6">
        <label for="input5th" class="form-label">5TH</label>
        <input type="number" class="form-control" id="input5th" name="5th">
    </div>
    <div class="col-md-6">
        <label for="input6th" class="form-label">6TH</label>
        <input type="number" class="form-control" id="input6th" name="6th">
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Market Value</button>
    </div>
</form>