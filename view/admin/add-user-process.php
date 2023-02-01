<?php
include_once __DIR__ . '../../../config.php';

if (isset($_POST['v_contact'])) {
    //VERIFY IF EXIST CONTACT

    if (AccountController::IsContactExist($_POST['v_contact'])) {
        echo 't';
    } else {
        echo 'f';
    }

}

if (isset($_POST['register'])) {
    //CREATE USER FIRST
    $u               = new User();
    $user_id         = XtraController::GenerateGUID();
    $u->UserId       = $user_id;
    $u->Name         = $_POST['name'];
    $u->Contact      = $_POST['contact'];
    $u->Barangay     = $_POST['barangay'];
    $u->Municipality = $_POST['municipality'];
    $u->Province     = $_POST['province'];

    $a                = new Account();
    $generated_pwd    = XtraController::GenerateRandompass();
    $a->UserId        = $user_id;
    $a->Contact       = $_POST['contact'];
    $a->AccountRoleId = Enum_Account_Role::Resident();
    $a->Password      = $generated_pwd;

    //FIRST CREATE USER

    //TODO SEND SMS TO RESIDENT
    if (MailController::SendTempAccount($_POST['contact'], $generated_pwd)) {
        if (UserController::Insert($u)) {
            if (AccountController::Insert($a)) {
                echo 't';
            } else {
                echo 'f';
            }
        }

    }

}
