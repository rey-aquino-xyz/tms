<?php

include_once __DIR__ . '/../config.php';

class OTPVerificationController{
    public static function Insert($otp, $email)
    {
        $sql = "INSERT INTO `otp_verification`(`otp`, `email`) VALUES (?,?)";
        try {
            DBx::ExecuteCommand($sql, [$otp, $email]);
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
    public static function Update($email, $otp)
    {
        $sql = "UPDATE `otp_verification` SET `otp`= ? WHERE `email`=?";
        try {
            DBx::ExecuteCommand($sql, [$otp, $email]);
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
    public static function Delete($email)
    {
        $sql = "DELETE FROM `otp_verification` WHERE `email` = ?";
        try {
            DBx::ExecuteCommand($sql, [$email]);
            return true;
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }
    public static function HasExistingOTP($email)
    {
        $sql    = "SELECT * FROM otp_verification WHERE email = ?";
        $result = DBX::GetData($sql, [$email]);

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function VerifyOTP($email, $otp)
    {
        $sql    = "SELECT * FROM otp_verification WHERE otp=? AND email=?";
        $result = DBx::GetData($sql, [$otp, $email]);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}