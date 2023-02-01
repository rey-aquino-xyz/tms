<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

$UserInfo = '';
if (isset($_POST['id'])) {
    $UserInfo = UserController::GetByUserId($_POST['id']);
}
?>
<script>
    $(document).ready(function () {

        $('[name="taxpayers-link"]').on('click', function (e) {
            e.preventDefault();
            $("#main-content").load('taxpayers.php');
        });
        $('[name="taxpayers-property-link"]').on('click', function (e) {
            e.preventDefault();
            var id = $(this).attr('href');
            $("#main-content").load('taxpayers-property.php', { id: id });
        });
        $('[name="add-form"]').on('submit', function (e) {
            e.preventDefault();
            // alert('hello');


            document.getElementById('inputPropertyAssesedValue').disable = false;
            document.getElementById('inputAgriAssesedValue').disable = false;
            document.getElementById('inputMarketValue').disable = false;

            document.getElementById('inputHectare').removeAttribute('required');
            document.getElementById('inputArea').removeAttribute('required');

            var form = new FormData(this);
            $.ajax({
                type: 'POST',
                url: 'taxpayers-process.php',
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.trim() == 't') {
                        swal("Land Property Addedd Successfully", "You can add another one.", "success", { button: false });
                        $('[name="add-form"]')[0].reset();
                    } else {
                        swal("Something Went Wrong", "Please try again later", "error", { button: false });
                    }
                }
            });
        });
        $('#inputAre').keypress(function () {
            calculateAssesedValue();
        });

        $('#inputHectare').keypress(function () {
            calculateAssesedValue();
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

            console.log(result);
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

    function getOptions(class_id) {
        var nonAgriculturalDiv = document.getElementById('non-agricultural');
        var agriculturalDiv = document.getElementById('agricultural');

        if (class_id == '<?=Enum_Property_Classification::Agricultural()?>') {
            agriculturalDiv.style.display = 'block';
            nonAgriculturalDiv.style.display = 'none';
        } else {
            agriculturalDiv.style.display = 'none';
            nonAgriculturalDiv.style.display = 'block';
        }

    }

    function getAgriSubMarketValue(agri_sub_class_id) {
        var agridSubMarketValEL = document.getElementById('selectAgriMarketValue');
        agridSubMarketValEL.innerHTML = "";

        var agridSubMarketValOpt = document.createElement('option');
        agridSubMarketValOpt.value = 0;
        agridSubMarketValOpt.innerHTML = '-- SELECT MARKET VALUE --';
        agridSubMarketValEL.appendChild(agridSubMarketValOpt);

        // var len = 0;
        $.post('taxpayers-process.php', { g_agri_sub_market_val: agri_sub_class_id }, function (result) {
            //var result = JSON.parse(result);
            // if (result != null) {
            //     len = result.length;
            // }

            var obj = JSON.parse(result);

            console.log(parseInt(obj[0]['First']));
            console.log(parseInt(obj[1]['Second']));
            console.log(parseInt(obj[2]['Third']));
            // console.log(obj);
            // var first = obj[0].First;
            // console.log(first);
            if (parseInt(obj[0]['First']) != 0) {
                var opt = document.createElement('option');
                opt.value = parseInt(obj[0]['First']);
                opt.innerHTML = parseInt(obj[0]['First']);
                agridSubMarketValEL.appendChild(opt);
            }


            if (parseInt(obj[1]['Second']) != 0) {
                var opt1 = document.createElement('option');
                opt1.value = parseInt(obj[1]['Second']);
                opt1.innerHTML = parseInt(obj[1]['Second']);
                agridSubMarketValEL.appendChild(opt1);

            }

            if (parseInt(obj[2]['Third']) != 0) {
                var opt2 = document.createElement('option');
                opt2.value = parseInt(obj[2]['Third']);
                opt2.innerHTML = parseInt(obj[2]['Third']);
                agridSubMarketValEL.appendChild(opt2);

            }

            if (parseInt(obj[3]['Fourth']) != 0) {
                var opt3 = document.createElement('option');
                opt3.value = parseInt(obj[3]['Fourth']);
                opt3.innerHTML = parseInt(obj[3]['Fourth']);
                agridSubMarketValEL.appendChild(opt3);
            }

            if (parseInt(obj[4]['Fifth']) != 0) {
                var opt4 = document.createElement('option');
                opt4.value = parseInt(obj[4]['Fifth']);
                opt4.innerHTML = parseInt(obj[4]['Fifth']);
                agridSubMarketValEL.appendChild(opt4);
            }

            if (parseInt(obj[5]['Sixth']) != 0) {
                var opt5 = document.createElement('option');
                opt5.value = parseInt(obj[5]['Sixth']);
                opt5.innerHTML = parseInt(obj[5]['Sixth']);
                agridSubMarketValEL.appendChild(opt5);
            }

        });
    }

    function getMarketValue(subclass_id) {

        //var classid = document.getElementById('selectClass');
        var marketVal = document.getElementById('inputMarketValue');


        $.post('taxpayers-process.php', { g_market_val: subclass_id}, function (result) {
            var obj = JSON.parse(result);
            console.log(parseInt(obj[0]['Value']));
            marketVal.value = parseInt(obj[0]['Value']);
        });
    }

    function calculateAssesedValue(value) {
        var class_id = document.getElementById('selectClass');
        var agri_sub_class = document.getElementById('selectAgriSubClass');
        var marketVal = document.getElementById('inputMarketValue');
        var agriMarketVal = document.getElementById('selectAgriMarketValue');

        var area = document.getElementById('inputArea');
        var hectare = document.getElementById('inputHectare');

        var propAssesedValue = document.getElementById('inputPropertyAssesedValue');
        var agriAssesedValue = document.getElementById('inputAgriAssesedValue');

        $.post('taxpayers-process.php',
            {
                x_calculate_assesed_value: 'POST', class_id: class_id.value,
                agri_sub_class: agri_sub_class.value, marketVal: marketVal.value,
                agriMarketVal: agriMarketVal.value, area: value,
                hectare: value
            }, function (result) {

                var obj = JSON.parse(result);

                console.log(parseFloat(obj[0]['Value']));
                if (class_id.value == '<?=Enum_Property_Classification::Agricultural()?>') {
                    agriAssesedValue.value = parseFloat(obj[0]['Value']).toFixed(2);
                } else {
                    propAssesedValue.value = parseFloat(obj[0]['Value']).toFixed(2);
                }
            });
    }
</script>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb h2">
                <li class="breadcrumb-item"><a href="#" name="taxpayers-link" class="text-decoration-none">Taxpayers</a>
                </li>
                <li class="breadcrumb-item"><a href="<?=$UserInfo->UserId?>" name="taxpayers-property-link"
                        class="text-decoration-none"><?=$UserInfo->Name?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Property</li>
            </ol>
        </nav>
    </h2>
</div>

<div class="row g-3">
    <form action="" class="row g-3" name="add-form" id="add-form">
        <input type="hidden" name="user_id" value="<?=$UserInfo->UserId?>">
        <div class="col-md-6">
            <label for="inputPIN" class="form-label">PIN No. / Tax Declaration No.</label>
            <input type="text" class="form-control" id="inputPIN" name="a_pin" required>
        </div>
        <div class="col-md-6">
            <label for="inputParentPIN" class="form-label">If Inherit provide Parent TDN</label>
            <input type="text" class="form-control" id="inputParentPIN" name="a_parent_pin">
        </div>

        <div class="col-md-6">
            <label for="selectProvince" class="form-label">Province</label>
            <select id="selectProvince" name="a_province_id" class="form-select"
                onchange="getMunicipalityByProvince(this.value);" required>
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
            <select id="selectMunicipality" name="a_municipality_id" class="form-select"
                onchange="getBarangayByMunicipality(this.value);" required>
                <option value="0">-- SELECT MUNICIPALITY --</option>
            </select>
        </div>
        <div class="col-md-12">
            <label for="selectBarangay" class="form-label">Barangay</label>
            <select id="selectBarangay" name="a_barangay_id" class="form-select" required>
                <option value="0">-- SELECT BARANGAY --</option>
            </select>
        </div>

        <div class="col-md-12">
            <label for="selectClass" class="form-label">Class</label>
            <select id="selectClass" class="form-select" name="a_class_id" onchange="getOptions(this.value);" required>
                <option value="0">-- SELECT CLASS --</option>
                <option value="<?=Enum_Property_Classification::Agricultural()?>" class="fw-bold">
                    <?=strtoupper('Agricultural Lands')?>
                </option>
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
            <!-- <div class="invalid-feedback">
                Class assessment value has been registered. Possible duplicate.
            </div> -->
        </div>

        <div id="non-agricultural" style="display: none;">
            <div class="col-md-12">
                <label for="selectSubClass" class="form-label">Sub Class</label>
                <select id="selectSubClass" name="a_sub_class" class="form-select"
                    onchange="getMarketValue(this.value);" required>
                    <option value="0">-- SUB CLASS --</option>
                    <?php foreach (SubClassificationController::Get() as $r): ?>
                    <option value="<?=$r['sub_class_id']?>">
                        <?=strtoupper($r['name'])?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-12">
                <label for="inputMarketValue" class="form-label">Market Value (Per sq.m.)</label>
                <input type="number" class="form-control" id="inputMarketValue" name="a_market_value" required disabled>
            </div>
            <div class="col-md-12">
                <label for="inputArea" class="form-label">Area</label>
                <input type="text" class="form-control" id="inputArea" name="a_area"
                    onkeyup="calculateAssesedValue(this.value)">
            </div>

            <div class="col-md-12">
                <label for="inputValue" class="form-label">Computed Assesed Value</label>
                <input type="number" class="form-control" id="inputPropertyAssesedValue" disabled>
            </div>
        </div>

        <div id="agricultural" style="display: none;">
            <div class="col-md-12">
                <label for="selectAgriSubClass" class="form-label">Sub Class</label>
                <select id="selectAgriSubClass" name="a_agri_sub_class" class="form-select"
                    onchange="getAgriSubMarketValue(this.value);" required>
                    <option value="0">-- SUB CLASS --</option>
                    <?php foreach (AgriSubClassController::Get() as $r): ?>
                    <option value="<?=$r['agri_sub_class_id']?>">
                        <?=strtoupper($r['name'])?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="col-md-12">
                <label for="selectAgriMarketValue" class="form-label">Market Value (Per Hectare)</label>
                <select id="selectAgriMarketValue" name="a_agri_market_value" class="form-select" required>
                    <option value="0">-- MARKET VALUE --</option>
                </select>
            </div>
            <div class="col-md-12">
                <label for="inputHectare" class="form-label">Hectare</label>
                <input type="text" class="form-control" id="inputHectare" name="a_hectare"
                    onkeyup="calculateAssesedValue(this.value)">
            </div>
            <div class="col-md-12">
                <label for="inputAssesedValue" class="form-label">Computed Assesed Value</label>
                <input type="number" class="form-control" id="inputAgriAssesedValue" disabled>
            </div>
        </div>
        <br>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary btn-md">Save Propoerty</button>
        </div>
    </form>
</div>

<br><br>