<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

function sendEmail($cltEmail, $cltFirstName, $body, $subject): bool {
    $mail = new PHPMailer(True);

    try {
        $mail->SMTPDebug = 2;                   // Enable verbose debug output
        $mail->isSMTP();                        // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com;';    // Specify main SMTP server
        $mail->SMTPAuth   = true;               // Enable SMTP authentication
        $mail->Username   = 'petconnecttech@gmail.com';     // SMTP username
        $mail->Password   = 'coxyzjeuktydfelh';         // SMTP password
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption, 'ssl' also accepted
        $mail->Port       = 587;                // TCP port to connect to

        $mail->setFrom('petconecttech@gmail.com', 'PetConnect Support');
        $mail->addAddress($cltEmail, $cltFirstName);
        $mail->isHTML();

        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;

    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function generateVerificationCode():string {
    return substr(number_format(time() * rand(), 0, '', ''), 0, 6);
}

function generateToken($cltID): string {
    try {
        return $cltID."-".bin2hex(random_bytes(16));
    } catch (Exception|\Exception $e) {
    }
}

//$serverName = $_SERVER['SERVER_PORT'];
//
//$cltEmail='philipe.barakat@yahoo.com';
//$cltToken = 'wsfgwergergijuergfuiernger';
//$url = "https://localhost:".$serverName."/password-recovery.php?cltEmail=".$cltEmail."&cltToken=".$cltToken;
//sendEmail('philipe.barakat@yahoo.com', 'Philipe',$url, 'test');