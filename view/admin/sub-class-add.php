<script>
    $(document).ready(function(){

        $('[name="sub-class-link"]').on('click', function(e){
            e.preventDefault();
            $("#main-content").load('sub-class.php');
        });

        $('[name="add-form"]').on('submit', function(e){
            e.preventDefault();
            var name = $("#inputName");
            var description = $("#inputDescription");
            $.post('sub-class-process.php', {c_name: name.val()}, function(result){
                if(result.trim() == 't'){
                    //DUPLICATE
                    name.addClass('is-invalid');
                }else{
                    //REGISTER
                    $.post('sub-class-process.php', {a_name: name.val(), a_description:description.val()}, function(result){
                        if(result.trim() == 't'){
                            //
                            name.removeClass('is-invalid');
                            swal("Registered Successfully", "You can register another one", "success", { button: false });
                            $('[name="add-form"]')[0].reset();
                        }else{
                            name.removeClass('is-invalid');
                            swal("Something Went Wrong", "Please try again later", "success", { button: false });
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
                <li class="breadcrumb-item"><a href="#" name="sub-class-link" class="text-decoration-none">Sub Classification</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add New Classification</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-12">
        <label for="inputName" class="form-label">Sub Category</label>
        <input type="text" class="form-control" id="inputName" required>
        <div class="invalid-feedback">
           Sub category already exist
        </div>
    </div>
    <div class="col-md-12">
        <label for="inputDescription" class="form-label">Description</label>
        <input type="text" class="form-control" id="inputDescription">
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Sub Classification</button>
    </div>
</form>