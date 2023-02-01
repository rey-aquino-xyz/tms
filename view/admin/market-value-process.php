<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

//GET MUNICIPALITY
if (isset($_POST['g_municipality'])) {
    $province_id = $_POST['g_municipality'];

    foreach (MunicipalityController::GetByProvince($province_id) as $r) {
        $data[] = array('id' => $r['municipality_id'], 'name' => $r['name']);
    }
    echo json_encode($data);
}

//GET BARANGAY
if (isset($_POST['g_barangay'])) {
    $municipality_id = $_POST['g_barangay'];

    foreach (BarangayController::GetByMunicipality($municipality_id) as $r) {
        $data[] = array('id' => $r['barangay_id'], 'name' => $r['name']);
    }
    echo json_encode($data);
}

if (isset($_POST['market_add'])) {
    $m                      = new MarketValue();
    $m->ClassificationId    = $_POST['classId'];
    $m->SubClassificationId = $_POST['subClassId'];
    $m->Value               = $_POST['value'];
    $m->Year                = $_POST['year'];

    if (MarketValueController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['e_provinceId'])) {
    $m                      = new MarketValue();
    $m->MarketValueId       = $_POST['e_id'];
    $m->ClassificationId    = $_POST['e_classId'];
    $m->SubClassificationId = $_POST['e_subClassId'];
    $m->Value               = $_POST['e_value'];
    $m->Year                = $_POST['e_year'];

    if (MarketValueController::Update($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
