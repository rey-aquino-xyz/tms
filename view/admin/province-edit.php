<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$Province = '';
if (isset($_POST['id'])) {
    $Province = ProvinceController::GetById($_POST['id']);
}

?>


<script>
    $(document).ready(function () {
        $('[name="province-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('province.php');
        });


        $('[name="edit-province-form"]').on('submit', function (e) {
            e.preventDefault();
            var name = $("#inputName");
            var id = '<?=$Province->ProvinceId?>';

            //CHECK DUPLICATE
            $.post('province-process.php', {c_province: name.val()}, function(result){
                if(result.trim() == 't'){
                    //HAS DUPLICATE
                    name.addClass('is-invalid');
                }
                else{
                    //REGISTER
                    $.post('province-process.php', {u_province: name.val(), id: id}, function(result){
                        if(result.trim() == 't'){
                            //REGISTERED
                            name.removeClass('is-invalid');
                            swal("Updated Successfully", "Province information has been updated", "success", { button: false });
                            $("#main-content").load('province.php');
                        }else{
                            name.removeClass('is-invalid');
                            swal("Something Went Wrong", "Please try againn later", "error", { button: false });
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
                <li class="breadcrumb-item active" aria-current="page">Edit Province Information</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="edit-province-form">
    <div class="col-md-12">
        <label for="inputName" class="form-label">Province</label>
        <input type="text" class="form-control" id="inputName" value="<?=$Province->Name?>" required>
        <div class="invalid-feedback">
            Province Already Registered
        </div>
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Province</button>
    </div>
</form>