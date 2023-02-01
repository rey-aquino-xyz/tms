<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_SESSION['contact'])) {
    $acc = AccountController::GetByContact($_SESSION['contact']);
// echo $acc->AccountRoleId;
    switch ($acc->AccountRoleId) {
        case Enum_Account_Role::Admin():
            header('location:/tms/view/admin', true, 301);
            exit();
            break;
        case Enum_Account_Role::Staff():
            header('location:/tms/', true, 301);
            exit();
            break;
        case Enum_Account_Role::Resident():
            // if ($acc->Status == Account_Status::Pending()) {
            //     header('location:/ibms/view/auth/otp-verification.php', true, 301);
            //     exit();
            // } elseif ($acc->Status == Account_Status::Suspended()) {
            //     //GOTO SUSPENDED PAGE
            // } else {
            //     header('location:/ibms/view/resident', true, 301);
            //     exit();
            // }
            header('location:/tms/view/user', true, 301);
            exit();
            break;
    }
}else{
    header('location:/tms/', true, 301);
}
