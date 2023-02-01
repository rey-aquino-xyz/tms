<?php
ob_start();
session_start();
include_once __DIR__ . '../../../config.php';

//CHECK EMAIL THEN SEND EMAIL
if (isset($_POST['c_email'])) {
    $email = $_POST['c_email'];
    $otp   = XtraController::GenerateOTP();

    if (AccountController::IsContactExist($email)) {
        //SEND MAIL
        if (OTPVerificationController::HasExistingOTP($email)) {
            OTPVerificationController::Delete($email);
        }

        if (MailController::SendOTPMail($email, $otp)) {
            if (OTPVerificationController::Insert($otp, $email)) {
                echo 't';
            }
        } else {
            echo 'f';
        }
    } else {
        echo 'f';
    }
}

if (isset($_POST['c_otp'])) {
    $otp      = $_POST['c_otp'];
    $email    = $_POST['email'];
    $temp_pwd = XtraController::GenerateRandompass();
    if (OTPVerificationController::VerifyOTP($email, $otp)) {
        //DELETE
        if (OTPVerificationController::Delete($email)) {
            if (MailController::SendTempAccount($email, $temp_pwd)) {
                if (AccountController::UpdatePassword($email, $temp_pwd)) {
                    echo 't';
                } else {
                    echo 'f';
                }
            } else {
                echo 'f';
            }
        }
    }
}
