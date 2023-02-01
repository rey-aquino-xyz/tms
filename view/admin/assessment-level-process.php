<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['c_class'])) {
    $class_id = $_POST['c_class'];
    if (AssessmentLevelController::HasDuplicate($class_id)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['a_class'])) {
    $class_id = $_POST['a_class'];
    $value    = $_POST['value'];

    $m                   = new AssessmentLevel();
    $m->ClassificationId = $class_id;
    $m->Value            = $value;

    if (AssessmentLevelController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['u_class'])) {
    $class_id = $_POST['u_class'];
    $value    = $_POST['value'];

    $m                   = new AssessmentLevel();
    $m->ClassificationId = $class_id;
    $m->Value            = $value;

    if (AssessmentLevelController::UpdateValByClass($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
