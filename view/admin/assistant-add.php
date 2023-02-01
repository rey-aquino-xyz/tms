<script>
    $(document).ready(function () {

        $('[name="sub-class-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('assistant.php');
        });

        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            var frm = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'assistant-process.php',
                data: frm,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.trim() == 't') {
                        swal("Added Assistant Successfully", "You can add another one", "success", { button: false });
                        $('[name="add-form"]')[0].reset();
                        // setTimeout(function () {
                        //     $("#main-content").load('taxpayers.php');
                        // }, 700);

                    } else {
                        swal("Something Went Wrong", "Please try again later", "error", { button: false });
                    }
                }
            });
            // $.post('sub-class-process.php', { a_name: name.val(), a_description: description.val() }, function (result) {
            //     if (result.trim() == 't') {
            //         //
            //         name.removeClass('is-invalid');
            //         swal("Registered Successfully", "You can register another one", "success", { button: false });
            //         $('[name="add-form"]')[0].reset();
            //     } else {
            //         name.removeClass('is-invalid');
            //         swal("Something Went Wrong", "Please try again later", "success", { button: false });
            //     }
            // });

            // var name = $("#inputName");
            // var description = $("#inputDescription");
            // $.post('sub-class-process.php', { c_name: name.val() }, function (result) {
            //     if (result.trim() == 't') {
            //         //DUPLICATE
            //         name.addClass('is-invalid');
            //     } else {
            //         //REGISTER

            //     }
            // });
        });

    });
</script>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="sub-class-link" class="text-decoration-none">Office
                        Assistants</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Add New Assistant</li>
            </ol>
        </nav>
    </h2>
</div>


<form action="" class="row g-3" name="add-form">
    <div class="col-md-12">
        <label for="inputName" class="form-label">Name</label>
        <input type="text" class="form-control" id="inputName" name="a_name" required>
        <div class="invalid-feedback">
            Sub category already exist
        </div>
    </div>
    <div class="col-md-12">
        <label for="inputContact" class="form-label">Contact</label>
        <input type="number" class="form-control" id="inputContact" name="a_contact">
    </div>
    <div class="col-md-12">
        <label for="inputAddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="inputAddress" name="a_address">
    </div>
    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md">Save Assistant</button>
    </div>
</form>