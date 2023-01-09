<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

function sendGmail($cltEmail, $cltFirstName, $body, $subject): bool
{
    $mail = new PHPMailer(True);

    try {
        $mail->SMTPDebug = 0;                   // Enable verbose debug output
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
        // ENABLE THIS TO ACTUAL SEND EMAILS
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function generateVerificationCode(): string
{
    return substr(number_format(time() * rand(), 0, '', ''), 0, 6);
}

function generateToken($cltID): string
{
    try {
        return $cltID . "-" . bin2hex(random_bytes(16));
    } catch (Exception | \Exception $e) {
    }
}

function returnEmailCodeValidationStructure($verificationCode): array
{
    $languagesList = returnLanguageList()[returnLanguage()]['php-mailer'];
    return  array(
        "body" => "<p>" . $languagesList['Verification code is:'] . " " . $verificationCode . "</p>",
        "subject" => $languagesList["Email Verification"],
    );
}


function returnEmailCodeDeviceStructure($DeviceCode): array
{
    $languagesList = returnLanguageList()[returnLanguage()]['php-mailer'];
    return  array(
        "body" => "<p>Merci pour votre achat! <br> Votre numéro d'appareil est :  " . $DeviceCode . "</p>",
        "subject" => "Votre commande PetConnect a bien été prise en charge.",
    );
}
