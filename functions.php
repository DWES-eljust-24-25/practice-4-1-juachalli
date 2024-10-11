<?php
//In this script, place the functions
declare(strict_types=1);

function validateContact(array $contact): array {
    $errors = [];

    //name, surname and birthdate: required.
    //as the date input must be of type date, we don’t need validation
    if (empty($contact["firstname"])) {
        $errors["firstname"] = "* First name is required";
    }

    if (empty($contact["surname"])) {
        $errors["surname"] = "* Surname is required";
    }

    if (empty($contact["birthdate"])) {
        $errors["birthdate"] = "* Birth date is required";
    }

    //phone: required and must be a valid phone number(use preg_match() and regular expresions).
    if (empty($contact["phone"])) {
        $errors["phone"] = "* Phone is required";
    } elseif (!preg_match("/^[0-9]{9}$/", $contact["phone"])) { //Validates 9-digit phone numbers
        $errors["phone"] = "* Phone has not a valid format";
    }

    //email: required and must be a valid email(usefilter_var()).
    if (empty($contact["email"])) {
        $errors["email"] = "* E-mail is required";
    } elseif (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "* E-mail has not a valid format";
    }

    return $errors;
}
