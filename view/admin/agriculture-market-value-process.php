<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['lands'])) {
    $m                 = new AgriMarketValue();
    $m->AgriSubClassId = $_POST['lands'];
    $m->First          = $_POST['1st'] ?? 0;
    $m->Second         = $_POST['2nd'] ?? 0;
    $m->Third          = $_POST['3rd'] ?? 0;
    $m->Fourth         = $_POST['4th'] ?? 0;
    $m->Fifth          = $_POST['5th'] ?? 0;
    $m->Sixth          = $_POST['6th'] ?? 0;

    if (AgriMarketValueController::Insert($m)) {
        echo 't';
    } else {
        echo 'f';
    }
}

if (isset($_POST['e_lands'])) {
    $m                    = new AgriMarketValue();
    $m->AgriMarketValueId = $_POST['e_id'];
    $m->AgriSubClassId    = $_POST['e_lands'];
    $m->First             = $_POST['e_1st'] ?? 0;
    $m->Second            = $_POST['e_2nd'] ?? 0;
    $m->Third             = $_POST['e_3rd'] ?? 0;
    $m->Fourth            = $_POST['e_4th'] ?? 0;
    $m->Fifth             = $_POST['e_5th'] ?? 0;
    $m->Sixth             = $_POST['e_6th'] ?? 0;

    if (AgriMarketValueController::UpdateById($m)) {
        //echo "<script>swal('Market Value Updated Successfully', 'information has been updated successfully', 'success', { button: false }); $('#main-content').load('agriculture-market-value.php');</script>";
        echo 't';
    } else {
        echo 'f';
    }
}
?>

