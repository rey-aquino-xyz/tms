<?php
include_once __DIR__ . '../../../config.php';

if (isset($_POST['v_tdn'])) {
    $pin = $_POST['v_tdn'];
    if (TDNController::IsPINExist($pin)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['register_tdn'])) {

    $m                   = new TDN();
    $m->Pin              = $_POST['pin'];
    $m->ClassificationId = $_POST['classification'];
    $m->Location         = $_POST['location'];
    $m->UserId           = $_POST['userid'];

    if (TDNController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['update_tdn'])) {
    $m                   = new TDN();
    $m->Pin              = $_POST['pin'];
    $m->ClassificationId = $_POST['classification'];
    $m->Location         = $_POST['location'];
    $m->TDNId            = $_POST['tdnid'];

    if (TDNController::UpdateById($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['update_tdn_pin'])) {
    $new_pin = $_POST['pin'];
    $id      = $_POST['tdnid'];
    if (TDNController::UpdateTDN($new_pin, $id)) {
        echo 't';
    } else {
        echo 'f';
    }
}
