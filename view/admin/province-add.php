<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
?>

<script>
    $(document).ready(function () {

        $('[name="province-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('province.php');
        });


        $('[name="add-province-form"]').on('submit', function(e){
            e.preventDefault();
            var name = $("#inputName");
            //CHECK FOR DUPLICATE
            $.post('province-process.php', {c_province: name.val()}, function(result){
                if(result.trim() == 't'){
                    //HAS DUPLICATE
                    name.addClass('is-invalid');

                }else{
                    //REGISTER
                    $.post('province-process.php', {a_province:name.val()}, function(result){
                        if(result.trim() == 't'){
                            //SUCCESS
                            name.removeClass('is-invalid');
                            swal("Registered Successfully", "You can register another one", "success", { button: false });
                            $('[name="add-province-form"]')[0].reset();
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
                <li class="breadcrumb-item"><a href="#" name="province-link" class="text-decoration-none">Province</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add New Province</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-province-form">
    <div class="col-md-12">
        <label for="inputName" class="form-label">Province</label>
        <input type="text" class="form-control" id="inputName" required>
        <div class="invalid-feedback">
            Province Already Registered
        </div>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Province</button>
    </div>
</form>
