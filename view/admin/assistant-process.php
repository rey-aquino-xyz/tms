<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';
if (isset($_POST['a_name'])) {
    $m = new Assistant();

    $m->Name    = $_POST['a_name'];
    $m->Contact = $_POST['a_contact'];
    $m->Address = $_POST['a_address'];

    if (AssistantController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}


if (isset($_POST['e_id'])) {
    $m = new Assistant();
    $m->AssistantId = $_POST['e_id'];
    $m->Name    = $_POST['e_name'];
    $m->Contact = $_POST['e_contact'];
    $m->Address = $_POST['e_address'];

    if (AssistantController::UpdateById($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}
?>
