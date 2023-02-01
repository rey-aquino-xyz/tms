<?php
include_once __DIR__ . '../../../config.php';
?>

<script>
    $(document).ready(function () {

        $('[name="taxpayer-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers.php');
        });

        $('[name="resident-registration-form"]').on('submit', function (e) {
            e.preventDefault();

            $("#loader").attr("style", "display:block");
            var contact = $("#inputPhone"); //$('[name= "r_contact"]');
            var name = $("#inputName"); // $('[name="r_name"]');
            var address = $("#inputAddress"); // $('[name="r_address"]');
            var barangay = $("#selectBarangay");
            var municipality = $("#selectMunicipality");
            var province = $("#selectProvince");

            //CHECK CONTACt FOR DUPLICATION
            $.post('taxpayers-process.php', { v_contact: contact.val().trim() }, function (result) {
                console.log(result);
                if (result.trim() == 't') {
                    //THROW ERROR FOR CONTACT DUPLICATION
                    contact.addClass('is-invalid');
                } else {
                    //REGISTER
                    $.post('taxpayers-process.php',
                        { register: 'POST', name: name.val(), address: address.val(), contact: contact.val(), barangay: barangay.val(), municipality: municipality.val(), province: province.val() },
                        function (result) {
                            console.log(result);
                            if (result.trim() == 't') {
                                $("#loader").attr("style", "display:none");
                                swal("Registered Successfully", "You can register another one", "success", { button: false });
                                contact.removeClass('is-invalid');
                                $('[name="resident-registration-form"]')[0].reset();
                            } else {
                                $("#loader").attr("style", "display:none");
                                swal("Registration Failed", "Something went wrong, Please try again later.", "error", { button: false });
                            }
                        });
                }
            })
        });

    });
    function getMunicipalityByProvince(province_id) {
        var municipalityEl = document.getElementById('selectMunicipality');
        municipalityEl.innerHTML = "";

        var barangayEl = document.getElementById('selectBarangay');
        barangayEl.innerHTML = "";

        var municipalityOpt = document.createElement('option');
        municipalityOpt.value = 0;
        municipalityOpt.innerHTML = '-- SELECT MUNICIPALITY --';
        municipalityEl.appendChild(municipalityOpt);

        var barangayOpt = document.createElement('option');
        barangayOpt.value = 0;
        barangayOpt.innerHTML = '-- SELECT BARANGAY --';
        barangayEl.appendChild(barangayOpt);

        var len = 0;
        $.post('market-value-process.php', { g_municipality: province_id }, function (result) {
            var result = JSON.parse(result);
            if (result != null) {
                len = result.length;
            }

            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var id = result[i].id;
                    var name = result[i].name;

                    //ADD OPTION TO MUNICIPALITY
                    var opt = document.createElement('option');
                    opt.value = id;
                    opt.innerHTML = name.toUpperCase();
                    municipalityEl.appendChild(opt);
                }
            }
        });
    }

    function getBarangayByMunicipality(municipality_id) {
        var barangayEl = document.getElementById('selectBarangay');
        barangayEl.innerHTML = "";

        var barangayOpt = document.createElement('option');
        barangayOpt.value = 0;
        barangayOpt.innerHTML = '-- SELECT BARANGAY --';
        barangayEl.appendChild(barangayOpt);

        var len = 0;
        $.post('market-value-process.php', { g_barangay: municipality_id }, function (result) {
            var result = JSON.parse(result);
            if (result != null) {
                len = result.length;
            }

            if (len > 0) {
                for (var i = 0; i < len; i++) {
                    var id = result[i].id;
                    var name = result[i].name;

                    //ADD OPTION TO MUNICIPALITY
                    var opt = document.createElement('option');
                    opt.value = id;
                    opt.innerHTML = name.toUpperCase();
                    barangayEl.appendChild(opt);
                }
            }
        });
    }
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
        <input type="email" class="form-control" id="inputPhone" name="r_phone" required>
        <div class="invalid-feedback">
            Email Already Registered
        </div>
    </div>

    <div class="col-md-6">
        <label for="selectProvince" class="form-label">Province</label>
        <select id="selectProvince" class="form-select" onchange="getMunicipalityByProvince(this.value);" name="province" required>
            <option value="0">-- SELECT PROVINCE --</option>
            <?php foreach (ProvinceController::Get() as $r): ?>
            <option value="<?=$r['province_id']?>">
                <?=strtoupper($r['name'])?>
            </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="selectMunicipality" class="form-label">Municipality</label>
        <select id="selectMunicipality" class="form-select" onchange="getBarangayByMunicipality(this.value);" name="municipality" required>
            <option value="0">-- SELECT MUNICIPALITY --</option>
        </select>
    </div>
    <div class="col-md-6">
        <label for="selectBarangay" class="form-label">Barangay</label>
        <select id="selectBarangay" class="form-select" name="barangay" required>
            <option value="0">-- SELECT BARANGAY --</option>
        </select>
    </div>

    <div class="d-flex">
        <button type="submit" class="btn btn-primary btn-md mb-3 mt-2">Save Taxpayer Information</button>
    </div>

</form>