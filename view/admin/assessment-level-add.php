<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
?>

<script>
    $(document).ready(function(){
        $('[name="assessment-level-link"]').on('click', function(e){
            e.preventDefault();
            $("#main-content").load('assessment-level.php');
        });

        $('[name="add-form"]').on('submit', function(e){
            e.preventDefault();
            var class_id = $("#selectClass");
            var value = $("#inputValue");

            $.post('assessment-level-process.php', {c_class: class_id.val()}, function(result){
                if(result.trim() == 't'){
                    //DUPLCITAE
                    class_id.addClass('is-invalid');
                }else{
                    //REGISTER
                    $.post('assessment-level-process.php', {a_class: class_id.val(), value:value.val()}, function(result){
                        if(result.trim() == 't'){
                            class_id.removeClass('is-invalid');
                            swal("Registered Successfully", "You can register another one", "success", { button: false });
                            $('[name="add-form"]')[0].reset();
                        }else{
                            class_id.removeClass('is-invalid');
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
                <li class="breadcrumb-item"><a href="#" name="assessment-level-link" class="text-decoration-none">Assessment Level</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add Assessment Level</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-6">
        <label for="selectClass" class="form-label">Class</label>
        <select id="selectClass" class="form-select" required>
            <option value="<?=Enum_Property_Classification::Residential()?>"> <?=strtoupper('Residential Lands')?></option>
            <option value="<?=Enum_Property_Classification::Agricultural()?>"><?= strtoupper('Agricultural Lands')?></option>
            <option value="<?=Enum_Property_Classification::Commercial()?>"><?= strtoupper('Commercial Lands')?></option>
            <option value="<?=Enum_Property_Classification::Industrial()?>"><?= strtoupper('Industrial Lands')?></option>
            <option value="<?=Enum_Property_Classification::Mineral()?>"><?= strtoupper('Mineral Lands')?></option>
            <option value="<?=Enum_Property_Classification::Timber()?>"><?= strtoupper('Timber Lands')?></option>
        </select>
        <div class="invalid-feedback">
            Class assessment value has been registered. Possible duplicate.
        </div>
    </div>
    <div class="col-md-6">
        <label for="inputValue" class="form-label">Assessment Level (Percent)</label>
        <input type="number" class="form-control" id="inputValue" required>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Assessment Value</button>
    </div>
</form>