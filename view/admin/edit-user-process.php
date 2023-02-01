<?php
include_once __DIR__ . '../../../config.php';

if (isset($_POST['update'])) {
    $u               = new User();
  
    $u->UserId       = $_POST['userid'];
    $u->Name         = $_POST['name'];
    $u->Contact      = $_POST['contact'];
    $u->Barangay     = $_POST['barangay'];
    $u->Municipality = $_POST['municipality'];
    $u->Province     = $_POST['province'];

    if(UserController::UpdateByUserId($u)){
        echo 't';
    }else{
        echo 'f';
    }
}


if(isset($_POST['update_contact'])){
    $new_contact = $_POST['update_contact'];
    $user_id = $_POST['userid'];

    if(AccountController::UpdateContact($user_id, $new_contact)){
        if(UserController::UpdateContact($user_id, $new_contact)){
            echo 't';
        }else{
            echo 'f';
        }
    }
}