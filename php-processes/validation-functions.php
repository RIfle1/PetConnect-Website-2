<?php

function validateUsername($value): void {
    if(empty($value)) {
//        header("Location: ../php-pages/restricted-access.php", true, 303);
        die("Username Is Required");
    }
}

function validateFirstName($value): void {
    if(empty($value)) {
        die("First Name Is Required");
    }
}

function validateLastName($value): void {
    if(empty($value)) {
        die("Last Name Is Required");
    }
}

function validatePhoneNumber($value): void {
    if (! filter_var($value, FILTER_VALIDATE_INT)) {
        die("Valid Phone Number is Required");
    }
}

function validateEmail($value): void {
    if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
        die("Valid Email is Required");
    }
}

function validatePassword($passwordValue, $passwordConfirmationValue):void {
    if (strlen($passwordValue) < 8){
        die("Password must be at least 8 characters");
    }
    else if (! preg_match("/[a-z]/i", $passwordValue)){
        die("Password must contain at least one letter");
    }
    else if (! preg_match("/[0-9]/i", $passwordValue)){
        die("Password must contain at least one number");
    }
    else if ($passwordValue !== $passwordConfirmationValue) {
        die("Passwords must match");
    }
}

function returnPasswordHash($password): string {
    return password_hash($password, PASSWORD_DEFAULT);
}

function validateAddress($value): void {
    if(empty($value)) {
        die("Address is Required");
    }
}

function validatePostalCode($value): void {
    if(empty($value)) {
        die("Postal Code is Required");
    }
}

function validateCity($value): void {
    if(empty($value)) {
        die("City is Required");
    }
}
