<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
?>

<script>
    $(document).ready(function () {

        $('[name="municipality-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('municipality.php');
        });


        $('[name="add-form"]').on('submit', function(e){
            e.preventDefault();
            var name = $("#inputName");
            var province_id = $("#selectProvince")
            //CHECK FOR DUPLICATE
            $.post('municipality-process.php', {c_municipality: name.val()}, function(result){
                if(result.trim() == 't'){
                    //HAS DUPLICATE
                    name.addClass('is-invalid');

                }else{
                    //REGISTER
                    $.post('municipality-process.php', {a_municipality:name.val(), province_id: province_id.val()}, function(result){
                        if(result.trim() == 't'){
                            //SUCCESS
                            name.removeClass('is-invalid');
                            swal("Registered Successfully", "You can register another one", "success", { button: false });
                            $('[name="add-form"]')[0].reset();
                        }else{
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
                <li class="breadcrumb-item"><a href="#" name="municipality-link" class="text-decoration-none">Municipality</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add New Municipality</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-6">
        <label for="inputName" class="form-label">Municipality</label>
        <input type="text" class="form-control" id="inputName" required>
        <div class="invalid-feedback">
            Municipality Already Registered
        </div>
    </div>
    <div class="col-md-6">
        <label for="selectProvince" class="form-label">Province</label>
        <select id="selectProvince" class="form-select" required>
            <?php foreach(ProvinceController::Get() as $r): ?>
            <option value="<?=$r['province_id']?>"><?=strtoupper($r['name'])?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Municipality</button>
    </div>
</form>
