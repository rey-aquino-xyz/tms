<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

?>
<script>
    $(document).ready(function () {
        $('[name="market-value-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('market-value.php');
        });

        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var classId = $("#selectClass");
            var subClassId = $("#selectSubClass");
            var value = $("#inputValue");
            var year = $("#inputYear");

            $.post('market-value-process.php', { market_add: 'POST',
               classId: classId.val(), subClassId: subClassId.val(), value: value.val(), year: year.val()
            }, function (result) {
                if (result.trim() == 't') {
                    //SAVED
                    swal("Registered Successfully", "You can register another one", "success", { button: false });
                    $('[name="add-form"]')[0].reset();
                } else {
                    //ERROR
                    swal("Something Went Wrong", "Please try again later", "error", { button: false });
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
    <div class="col-md-6">
        <label for="selectClass" class="form-label">Class</label>
        <select id="selectClass" class="form-select" required>
            <option value="<?=Enum_Property_Classification::Residential()?>" class="fw-bold">
                <?=strtoupper('Residential Lands')?>
            </option>
            <option value="<?=Enum_Property_Classification::Commercial()?>" class="fw-bold">
                <?=strtoupper('Commercial Lands')?>
            </option>
            <option value="<?=Enum_Property_Classification::Industrial()?>" class="fw-bold">
                <?=strtoupper('Industrial Lands')?>
            </option>
            <option value="<?=Enum_Property_Classification::Mineral()?>" class="fw-bold">
                <?=strtoupper('Mineral Lands')?>
            </option>
            <option value="<?=Enum_Property_Classification::Timber()?>" class="fw-bold">
                <?=strtoupper('Timber Lands')?>
            </option>
        </select>
        <div class="invalid-feedback">
            Class assessment value has been registered. Possible duplicate.
        </div>
    </div>
    <div class="col-md-6">
        <label for="selectSubClass" class="form-label">Sub Classification</label>
        <select id="selectSubClass" class="form-select" required>
            <?php foreach (SubClassificationController::Get() as $r): ?>
            <option value="<?=$r['sub_class_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputValue" class="form-label">Value per sq.m.</label>
        <input type="number" class="form-control" id="inputValue" required>
    </div>

    <div class="col-md-6">
        <label for="inputYear" class="form-label">Year</label>
        <input type="number" class="form-control" id="inputYear" required>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Market Value</button>
    </div>
</form>