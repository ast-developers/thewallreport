<?php
namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use App\Config;


class Mail
{
    public static function sendMail($toEmail,$subject,$body){
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = Config::SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = Config::SMTP_USERNAME;
        $mail->Password = Config::SMTP_PASSWORD;
        $mail->SMTPSecure = "tls";
        $mail->Port = Config::SMTP_PORT;
        $mail->smtpConnect(
            array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            )
        );

        $mail->From = "dhaval.prajapati333@gmail.com";
        $mail->FromName = "The Wall Report";

        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = "This is the plain text version of the email content";

        if(!$mail->send())
        {
            return ['success'=>false,'message'=>$mail->ErrorInfo];
        }
        else
        {
            return ['success'=>true];
        }
    }

}