<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['c_barangay'])) {
    $name            = $_POST['c_barangay'];
    $municipality_id = $_POST['municipality_id'];

    if (BarangayController::HasDuplicate($name, $municipality_id)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['a_barangay'])) {
    $name            = $_POST['a_barangay'];
    $municipality_id = $_POST['municipality_id'];

    $m                 = new Barangay();
    $m->MunicipalityId = $municipality_id;
    $m->Name           = $name;

    if (BarangayController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }

}

if (isset($_POST['u_barangay'])) {
    $name            = $_POST['u_barangay'];
    $municipality_id = $_POST['municipality_id'];
    $barangay_id     = $_POST['id'];

    $m                 = new Barangay();
    $m->MunicipalityId = $municipality_id;
    $m->Name           = $name;
    $m->BarangayId     = $barangay_id;

    if (BarangayController::Update($m)) {
        echo 't';
    } else {
        echo 'f';
    }

}
