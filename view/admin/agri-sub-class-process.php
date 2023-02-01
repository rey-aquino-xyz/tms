<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['c_name'])) {
    $name = $_POST['c_name'];
    if (AgriSubClassController::HasDuplicate($name)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['a_name'])) {
    $name    = $_POST['a_name'];
    $m       = new AgriSubClass();
    $m->Name = $name;
    if (AgriSubClassController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['u_name'])) {
    $name              = $_POST['u_name'];
    $id                = $_POST['id'];
    $m                 = new AgriSubClass();
    $m->Name           = $name;
    $m->AgriSubClassId = $id;
    if (AgriSubClassController::Update($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
