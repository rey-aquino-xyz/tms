<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['c_province'])) {
    $name = $_POST['c_province'];
    if (ProvinceController::HasDuplicate($name)) {
        echo 't';
    } else {
        'f';
    }
}

if (isset($_POST['a_province'])) {
    $name    = $_POST['a_province'];
    $m       = new Province();
    $m->Name = $name;
    if (ProvinceController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['u_province'])) {
    $name = $_POST['u_province'];
    $id   = $_POST['id'];

    $m             = new Province();
    $m->ProvinceId = $id;
    $m->Name       = $name;
    if (ProvinceController::Update($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
