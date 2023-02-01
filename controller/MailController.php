<?php
include_once __DIR__ . '/../config.php';

use PHPMailer\PHPMailer\PHPMailer;

class MailController
{

    public static function SendMail($contact, $subject, $body): bool
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host     = 'smtp.gmail.com';
            $mail->Mailer   = "smtp";
            $mail->SMTPAuth = true;

            // $mail->Username = 'ibarangay.ila@gmail.com';
            // $mail->Password = 'uugmsdgmfgvcpfkj'; 
            
            $mail->Username = 'delfinalbano.treasuryoffice@gmail.com';
            $mail->Password = 'camqunilonfvojfa'; 

            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;

            $mail->IsHTML(true);
            $mail->AddAddress($contact);
            $mail->Subject = $subject;
            $content       = $body;
            $mail->Body    = $content;

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
    public static function SendOTPMail($email, $otp)
    {
        $User         = UserController::GetByContact($email);
        $UserFullname = $User->Name;
        //EMAIL SUBJECT
        $email_subject = "Email Verification";
        //EMAIL BODY
        $email_body = 'Your Email Verification One-Time Password/OTP is : <b>' . $otp . '</b><br><br>DO NOT SHARE THIS OTP WITH ANYONE!. <br>Understand & examine closely where you input this. Report to the Office of the Treasury Department immediately if you did not initiate this login or request. You can also log in to your account and reset your password immediately for your security.<br><br>Thank you.<br><br>From,<br><br><br>Office of the Treasury Department<br><br><b><i>This message is for the designated recipient only and may contain confidential, private and/or privileged information. If you have received it in error, please delete it and advise the sender immediately. You should not copy or use it for any other purpose, nor disclose its contents to any other person.</i></b>';

        if (MailController::SendMail($email, $email_subject, $email_body)) {
            return true;
        } else {
            return false;
        }
    }

    public static function SendRecoveryMail($email, $otp)
    {
        $User         = UserController::GetByContact($email);
        $UserFullname = $User->Name;
        //EMAIL SUBJECT
        $email_subject = "Account Recovery";
        //EMAIL BODY
        $email_body = 'Your Recovery Code is : <b>' . $otp . '</b><br><br><b>DO NOT SHARE THIS CODE WITH ANYONE!.</b> <br>Understand & examine closely where you input this. Report to the Office of the Treasury Department immediately if you did not initiate this recovery or request. <br><br>Thank you.<br><br>From,<br><br><br>Office of the Treasury Department<br><br><b><i>This message is for the designated recipient only and may contain confidential, private and/or privileged information. If you have received it in error, please delete it and advise the sender immediately. You should not copy or use it for any other purpose, nor disclose its contents to any other person.</i></b>';

        if (MailController::SendMail($email, $email_subject, $email_body)) {
            return true;
        } else {
            return false;
        }
    }

    public static function SendTempAccount($email, $temp_pwd)
    {
        $User         = UserController::GetByContact($email);
        $UserFullname = $User->Name;

        //EMAIL SUBJECT
        $email_subject = "Temporary Account Details";
        //EMAIL BODY
        $email_body = 'Your temporary password is : <b>' . $temp_pwd . '</b><br><br><b>DO NOT SHARE THIS PASSWORD WITH ANYONE!.</b> <br>Understand & examine closely where you input this. Report to the Office of the Treasury Department immediately if you did not initiate this recovery or request. <br><br>Thank you.<br><br>From,<br><br><br>Office of the Treasury Department<br><br><b><i>This message is for the designated recipient only and may contain confidential, private and/or privileged information. If you have received it in error, please delete it and advise the sender immediately. You should not copy or use it for any other purpose, nor disclose its contents to any other person.</i></b>';

        if (MailController::SendMail($email, $email_subject, $email_body)) {
            return true;
        } else {
            return false;
        }
    }

}
