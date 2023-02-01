<?php
include_once __DIR__ . '../../../config.php';

//UTILS
include_once __DIR__ . '../../../utils/DataTable.php';
?>
<!-- AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- SWEET ALERT -->
<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>

<script>
    $(document).ready(function () {

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('users.php');
        })

        $('[name="resident-registration-form"]').on('submit', function (e) {
            e.preventDefault();

            $("#loader").attr("style", "display:block");
            var contact = $("#inputPhone"); //$('[name= "r_contact"]');
            var name = $("#inputName"); // $('[name="r_name"]');
            var address = $("#inputAddress"); // $('[name="r_address"]');
            var barangay = $("#brgySelect");
            var municipality = $("#municipalitySelect");
            var province = $("#provinceSelect");

            //CHECK CONTACt FOR DUPLICATION
            $.post('add-user-process.php', { v_contact: contact.val().trim() }, function (result) {
                console.log(result);
                if (result.trim() == 't') {
                    //THROW ERROR FOR CONTACT DUPLICATION
                    contact.addClass('is-invalid');
                } else {
                    //REGISTER
                    $.post('add-user-process.php',
                        { register: 'POST', name: name.val(), address: address.val(), contact: contact.val(), barangay: barangay.val(), municipality: municipality.val(), province: province.val() },
                        function (result) {
                            console.log(result);
                            if (result.trim() == 't') {
                                $("#loader").attr("style", "display:none");
                                swal("Registered Successfully", "You can register another one", "success", { button: false });
                                contact.removeClass('is-invalid');
                                $('[name="resident-registration-form"]')[0].reset();
                            }else{
                                $("#loader").attr("style", "display:none");
                                swal("Registration Failed", "Something went wrong, Please try again later.", "error", { button: false });
                            }
                        });
                }
            })
        })
    });

</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="taxpayer-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Register New Taxpayer</li>
            </ol>
        </nav>
    </h2>
</div>
<div class="loader" id="loader" data-wordLoad="Loading . . ." style="display: none;"></div>
<form class="row g-3" name="resident-registration-form">

    <h4 class="p-2 bg-primary text-light rounded">Personal Information</h4>

    <div class="col-md-12">
        <label for="inputName" class="form-label fw-bold">Name <span class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputName" placeholder="Juan Dela Cruz Jr. II" name="r_name"
            required>
    </div>
    <div class="col-md-12">
        <label for="inputPhone" class="form-label fw-bold">Email</label>
        <input type="email" class="form-control" id="inputPhone" name="r_phone"
            required>
        <div class="invalid-feedback">
            Email Already Registered
        </div>
    </div>
    <!-- <div class="col-md-3">
        <label for="inputMiddlename" class="form-label fw-bold">Middlename</span></label>
        <input type="text" class="form-control" id="inputMiddlename" name="mn">
    </div>
    <div class="col-md-3">
        <label for="inputLastname" class="form-label fw-bold">Lastname <span class="text-danger fw-bold ">*</span></label>
        <input type="text" class="form-control" id="inputLastname" name="ln" required>
    </div>
    <div class="col-md-3">
        <label for="inputSuffix" class="form-label fw-bold">Suffix</span></label>
        <input type="text" class="form-control" id="inputSuffix" name="suffix">
    </div> -->
    <!-- <div class="col-md-4">
        <label for="inputGender" class="form-label fw-bold">Gender</label>
        <select id="inputGender" class="form-select" name="gender" required>
            <option value="0">Male</option>
            <option value="1">Female</option>
        </select>
    </div>
    <div class="col-md-4">
        <label for="selectCivilStatus" class="form-label fw-bold">Civil Status</label>
        <select id="selectCivilStatus" class="form-select" name="civilstatus" required>
            <option value="<?=Enum_Civil_Status::Single()?>">Single</option>
            <option value="<?=Enum_Civil_Status::Married()?>">Married</option>
            <option value="<?=Enum_Civil_Status::Separated()?>">Separated</option>
            <option value="<?=Enum_Civil_Status::Widowed()?>">Widow/er</option>
        </select>
    </div> -->
    <!-- <div class="col-md-4">
        <label for="inputDOB" class="form-label fw-bold">Date of Birth</label>
        <input type="date" class="form-control" id="inputDOB" placeholder="Date of Birth" name="dob" required>
    </div> -->

    <!-- <h4 class="p-2 bg-primary text-light rounded">Address Information</h4> -->
    <!-- <p class="p-1 bg-secondary text-light text-center">Address Information</p> -->
    <!-- <div class="col-6">
        <label for="inputBirthPlace" class="form-label fw-bold">Birth Place</label>
        <input type="text" class="form-control" id="inputBirthPlace" placeholder="1234 Main St" name="birthplace"
            required>
    </div> -->

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
    <!-- <div class="col-6">
        <label for="inputAddress" class="form-label fw-bold">Address</label>
        <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="r_address" required>
    </div> -->

    <!-- <h4 class="p-2 bg-primary text-light rounded">Contact Information</h4> -->

    <!-- <div class="col-md-6">
        <label for="inputEmail" class="form-label fw-bold">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email" required>
    </div> -->


    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2">Save Taxpayer Information</button>
    </div>

</form>