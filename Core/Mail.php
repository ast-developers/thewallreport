<?php
namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use App\Config;


class Mail
{
    public static function sendMail($toEmail,$subject,$body){

        $body .= '<p>Thanks,</p>';
        $body .= '<p>' . Config::APP_NAME . ' Team.</p>';

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = Config::SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = Config::SMTP_USERNAME;
        $mail->Password = Config::SMTP_PASSWORD;
        $mail->SMTPSecure = "tls";
        $mail->Port = Config::SMTP_PORT;
        //$mail->SMTPDebug = 4;
        $mail->smtpConnect(
            array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                    "allow_self_signed" => true
                )
            )
        );

        $mail->From     = Config::SMTP_USERNAME;
        $mail->FromName = Config::SMTP_FROM_NAME;

        $mail->addAddress($toEmail);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

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