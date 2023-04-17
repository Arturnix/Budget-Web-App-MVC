<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\PHPMailer_Config;

//require 'vendor/PHPMailer/src/Exception.php';
//require 'vendor/PHPMailer/src/PHPMailer.php';
//require 'vendor/PHPMailer/src/SMTP.php';

require dirname(__DIR__) . '/vendor/autoload.php';

class Mail {

public static function send($to, $subject, $text, $html) {

$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
    $mail->IsHTML(true);
    $mail->CharSet = "text/html; charset=UTF-8;";
    $mail->isSMTP();
    $mail->Host = PHPMailer_Config::PHPMAILER_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = PHPMailer_Config::PHPMAILER_USERNAME;
    $mail->Password = PHPMailer_Config::PHPMAILER_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('testujmailer@wp.pl');
    $mail->addAddress($to);
    //$mail->addReplyTo('info@example.com', 'Information');
    $mail->Subject = $subject;
    $mail->Body = $html;
    $mail->AltBody  =  $text;

    $mail->send();

    echo 'Message sent';

} catch (Exception $e) {

    echo 'Message not sent: ', $mail->ErrorInfo;

}
}
}