<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['c_municipality'])) {
    $name = $_POST['c_municipality'];
    if (MunicipalityController::HasDuplicate($name)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['a_municipality'])) {
    $name        = $_POST['a_municipality'];
    $province_id = $_POST['province_id'];
    // $id          = $_POST['id'];

    $m = new Municipality();
    // $m->MunicipalityId = $id;
    $m->ProvinceId = $province_id;
    $m->Name       = $name;

    if (MunicipalityController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }

}

if (isset($_POST['u_municipality'])) {
    $name        = $_POST['u_municipality'];
    $province_id = $_POST['province_id'];
    $id          = $_POST['id'];

    $m                 = new Municipality();
    $m->MunicipalityId = $id;
    $m->ProvinceId     = $province_id;
    $m->Name           = $name;

    if (MunicipalityController::Update($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['un_municipality'])) {
    $name = $_POST['un_municipality'];
    $id   = $_POST['id'];
    if (MunicipalityController::UpdateByName($id, $name)) {
        echo 't';
    } else {
        echo 'f';
    }

}
