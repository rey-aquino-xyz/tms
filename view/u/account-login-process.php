<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

//CHECK IF CONTACT NO IS VALID OR EXISTING
if (isset($_POST['v_contact'])) {
    if (AccountController::IsContactExist($_POST['v_contact'])) {
        echo 't';
    } else {
        echo 'f';
    }
}

//AUTHENTICATE CONTACT AND PASSWORD
if (isset($_POST['l_contact'])) {
    $contact = $_POST['l_contact'];
    $pwd     = $_POST['l_pwd'];
    if (AccountController::Authenticate($contact, $pwd)) {
        $_SESSION['contact'] = $contact;
        //header('location:account-login.php?err=0', true, 301);
        echo 't';
        exit();
    } else {
        echo 'f';
    }
}
