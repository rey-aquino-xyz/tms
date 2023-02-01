<?php
include_once __DIR__ . '../../../config.php';
//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
$User = '';
if (isset($_POST['user_id'])) { $User = UserController::GetByUserId($_POST['user_id']); }
?>

<!-- AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- SWEET ALERT -->
<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

<script>
    $(document).ready(function () {

        document.getElementById("brgySelect").value = "<?php echo $User->Barangay ?>";

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('users.php');
        })

        $('[name="resident-registration-form"]').on('submit', function (e) {
            e.preventDefault();

            document.getElementById("inputPhone").disabled = false;

            var contact = $("#inputPhone"); //$('[name= "r_contact"]');
            var name = $("#inputName"); // $('[name="r_name"]');
            var address = $("#inputAddress"); // $('[name="r_address"]');
            var barangay = $("#brgySelect");
            var municipality = $("#municipalitySelect");
            var province = $("#provinceSelect");

            $.post('edit-user-process.php',
                { update: 'POST', userid: "<?php echo $User->UserId ?>", name: name.val(), address: address.val(), contact: contact.val(), barangay: barangay.val(), municipality: municipality.val(), province: province.val() },
                function (result) {
                    console.log(result);
                    if (result.trim() == 't') {
                        swal("Updated Successfully", "Taxpayer Information has been updated", "success", { button: false });
                        $("#main-content").load('view-user.php', {user_id : "<?php echo $User->UserId ?>"});
                    }
                });
        })

        $('[name="edit-contact-link"]').on('click', function(e){
            e.preventDefault();
            $("#contact-content").load('view-contact-user.php', {userid : "<?php echo $User->UserId ?>"});
        })
    });
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Taxpayer Information</li>
            </ol>
        </nav>
    </h2>

</div>
<form class="row g-3" name="resident-registration-form">

    <h4 class="p-2 bg-primary text-light rounded">Personal Information</h4>

    <div class="col-md-12">
        <label for="inputName" class="form-label fw-bold">Name <span class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputName" value="<?=$User->Name?>"
            placeholder="Juan Dela Cruz Jr. II" name="r_name" required>
    </div>
    <div class="col-md-4">
        <label for="brgySelect" class="form-label fw-bold">Barangay</label>
        <select id="brgySelect" class="form-select" name="r_barangay" required>
            <option value="Aga">Aga</option>
            <option value="Andarayan">Andarayan</option>
            <option value="Aneg">Aneg</option>
            <option value="Bayabo">Bayabo</option>
            <option value="Calinaoan Sur">Calinaoan Sur</option>
            <option value="Caloocan">Caloocan</option>
            <option value="Capitol">Capitol</option>
            <option value="Carmencita">Carmencita</option>
            <option value="Concepcion">Concepcion</option>
            <option value="Maui">Maui</option>
            <option value="Quibal">Quibal</option>
            <option value="Ragan Almacen">Ragan Almacen</option>
            <option value="Ragan Norte">Ragan Norte</option>
            <option value="Ragan Sur (Poblacion)">Ragan Sur (Poblacion)</option>
            <option value="Rizal">Rizal</option>
            <option value="San Andres">San Andres</option>
            <option value="San Antonio">San Antonio</option>
            <option value="San Isidro">San Isidro</option>
            <option value="San Jose">San Jose</option>
            <option value="San Juan">San Juan</option>
            <option value="San Macario">San Macario</option>
            <option value="San Nicolas (Fusi)">San Nicolas (Fusi)</option>
            <option value="San Patricio">San Patricio</option>
            <option value="San Roque">San Roque</option>
            <option value="Santo Rosario">Santo Rosario</option>
            <option value="Santor">Santor</option>
            <option value="Villa Luz">Villa Luz</option>
            <option value="Villa Pereda">Villa Pereda</option>
            <option value="Visitacion">Visitacion</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="municipalitySelect" class="form-label fw-bold">Municipality</label>
        <select id="municipalitySelect" class="form-select" name="municipality" required>
            <option value="Delfin Albano">Delfin Albano</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="provinceSelect" class="form-label fw-bold">Province</label>
        <select id="provinceSelect" class="form-select" name="province" required>
            <option value="Isabela">Isabela</option>
        </select>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2">Update Taxpayer Information</button>
    </div>
</form>
<hr>
<div id="contact-content">
    <div class="col-md-12">
        <label for="inputPhone" class="form-label fw-bold">Contact Number</label>
        <input type="tel" class="form-control" id="inputPhone" value="<?=$User->Contact?>" name="r_phone"
            placeholder="09xxxxxxxxxxx" pattern="[0-9]{4}[0-9]{7}" disabled>
        <div class="invalid-feedback">
            Contact Number Already Registered
        </div>
    </div>
    <div class="d-flex">
        <button class="btn btn-primary btn-md mb-3 mt-2" name="edit-contact-link">Edit Contact Information</button>
    </div>
</div>