<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['c_name'])) {
    $name = $_POST['c_name'];
    if (SubClassificationController::HasDuplicate($name)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['a_name'])) {
    $name           = $_POST['a_name'];
    $description    = $_POST['a_description'];
    $m              = new SubClassification();
    $m->Name        = $name;
    $m->Description = $description;
    if (SubClassificationController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['u_name'])) {
    $name                   = $_POST['u_name'];
    $description            = $_POST['u_description'];
    $id                     = $_POST['id'];
    $m                      = new SubClassification();
    $m->Name                = $name;
    $m->Description         = $description;
    $m->SubClassificationId = $id;
    if (SubClassificationController::Update($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
