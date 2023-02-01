<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

if (isset($_POST['v_code'])) {
    $code  = $_POST['v_code'];
    $email = $_POST['email'];

    if (OTPVerificationController::VerifyOTP($email, $code)) {
        if (OTPVerificationController::Delete($email)) {
            echo 't';
        }
    } else {
        echo 'f';
    }

}

if (isset($_POST['x_send'])) {
//SEND OTP
    $email = $_SESSION['contact'];
    $otp   = XtraController::GenerateOTP();

    if (OTPVerificationController::HasExistingOTP($email)) {
        //DELETE AND SEND NEW
        OTPVerificationController::Delete($email);
    }
    if (MailController::SendOTPMail($email, $otp)) {
        if (OTPVerificationController::Insert($otp, $email)) {
            echo 't';
        } else {
            echo 'f';
        }
    } else {
        echo 'f';
    }

}

//DELETE CODE IN DB WHEN CANCEL BY USER
if (isset($_POST['x_cancel'])) {
    $email = $_SESSION['contact'];
    if (OTPVerificationController::Delete($email)) {
        echo 't';
    } else {
        echo 'f';
    }
}

//CHECK EMAIL DUPLICATE
if (isset($_POST['c_email'])) {
    $email = $_POST['c_email'];
    if (AccountController::IsContactExist($email)) {
        echo 't';
    } else {
        echo 'f';
    }
}

//UPDATE EMAIL
if (isset($_POST['u_email'])) {
    //GET ACCOUNT
    $a = AccountController::GetByContact($_SESSION['contact']);

    $new_email = $_POST['u_email'];

    if (AccountController::UpdateContact($a->UserId, $new_email)) {
        if (UserController::UpdateContact($a->UserId, $new_email)) {
            unset($_SESSION['contact']);
            $_SESSION['contact'] = $new_email;
            echo 't';
        } else {
            echo 'f';
        }
    }
}

//UPDATE PASSWORD
if (isset($_POST['u_password'])) {
    $new_pwd = $_POST['u_password'];

    if (AccountController::UpdatePassword($_SESSION['contact'], $new_pwd)) {
        echo 't';
    } else {
        echo 'f';
    }
}
