<?php

function checkPasswordLength ($password): void
{
    if (strlen($password) < 8){
        die("Password must be at least 8 characters");
    }
}

function checkPasswordLetter($password): void
{
    if (! preg_match("/[a-z]/i", $password)){
        die("Password must contain at least one letter");
    }
}

function checkPasswordNumber($password): void
{
    if (! preg_match("/[0-9]/i", $password)){
        die("Password must contain at least one number");
    }
}

function checkPasswordMatch($password, $newPasswordConfirmation): void
{
    if ($password !== $newPasswordConfirmation) {
        die("Passwords must match");
    }
}

function returnPasswordHash($password): string {
    return password_hash($password, PASSWORD_DEFAULT);
}
