<?php
//In this script, place the functions
declare(strict_types=1);

/*
function validateContact(Contact $contact): array {
    $errors = [];

    //name, surname and birthdate: required.
    //as the date input must be of type date, we don’t need validation
    if (empty($contact->getName())) {
        $errors["name"] = "* First name is required";
    }

    if (empty($contact->getSurname())) {
        $errors["surname"] = "* Surname is required";
    }

    if (empty($contact->getBirthdate())) {
        $errors["birthdate"] = "* Birth date is required";
    }

    //phone: required and must be a valid phone number(use preg_match() and regular expressions).
    if (empty($contact->getPhone())) {
        $errors["phone"] = "* Phone is required";
    } elseif (!preg_match("/^[0-9]{9}$/", $contact->getPhone())) { //Validates 9-digit phone numbers
        $errors["phone"] = "* Phone has not a valid format => 9-digit phone number";
    }

    //email: required and must be a valid email(use filter_var()).
    if (empty($contact->getEmail())) {
        $errors["email"] = "* E-mail is required";
    } elseif (!filter_var($contact->getEmail(),FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "* E-mail has not a valid format => pattern name@domain.ext";
    }

    return $errors;
}
*/
/* U04
function validateContact(array $contact): array {
    $errors = [];

    //name, surname and birthdate: required.
    //as the date input must be of type date, we don’t need validation
    if (empty($contact["name"])) {
        $errors["name"] = "* First name is required";
    }

    if (empty($contact["surname"])) {
        $errors["surname"] = "* Surname is required";
    }

    if (empty($contact["birthdate"])) {
        $errors["birthdate"] = "* Birth date is required";
    }

    //phone: required and must be a valid phone number(use preg_match() and regular expressions).
    if (empty($contact["phone"])) {
        $errors["phone"] = "* Phone is required";
    } elseif (!preg_match("/^[0-9]{9}$/", $contact["phone"])) { //Validates 9-digit phone numbers
        $errors["phone"] = "* Phone has not a valid format => 9-digit phone number";
    }

    //email: required and must be a valid email(use filter_var()).
    if (empty($contact["email"])) {
        $errors["email"] = "* E-mail is required";
    } elseif (!filter_var($contact["email"],FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "* E-mail has not a valid format => pattern name@domain.ext";
    }

    return $errors;
}
*/


function getContact(int $id, array $contacts) : Contact {
    //Check if the $id parameter exits in the array $contacts parameter
    //If exists load contact data from the array
    //If do not exists return an empty object

    foreach ($contacts as $contactRow) {
        if ($contactRow instanceof Contact && $contactRow->getId() == $id) {
            return $contactRow;
        }
    }

    return new Contact();
}
/* U04
function getContact(string $id, array $contacts) : array {
    //Check if the $id parameter exits in the array $contacts parameter
    //If exists load contact data from the array
    //If do not exist return an empty array

    $contact = []; //Array to store the form data

    foreach ($contacts as $contactRow) {
        if ($contactRow['id'] == $id) {
            return $contactRow;
        }
    }

    return array();
}
*/


function addContact(Contact $contact, array $contacts) : array {
    //Add new contact to contacts array
    $id = 0;

    //We get the max id value
    foreach ($contacts as $contactRow) {
        if ($contactRow instanceof Contact && $contactRow->getId() >= $id) {
            $id = $contactRow->getId() + 1;
        }
    }

    //We set the id field of the new contact
    $contact->setId($id);

    //and add it to the array
    array_push($contacts,$contact);

    return $contacts;
}
/* U04
function addContact(array $contact, array $contacts) : array {
    //Add new contact to contacts array
    $id = "0";

    //We get the max id value
    foreach ($contacts as $contactRow) {
        if ($contactRow['id'] >= $id) {
                $id = $contactRow['id'] + 1;
            }
    }

    //We set the id field of the new contact
    $contact["id"] = $id;

    //and add it to the array
    array_push($contacts,$contact); 

    return $contacts;
}
*/

function updateContact(Contact $contact, array $contacts) : array {
    //We go through the original array and for each row we insert it into a new array.
    //When we find the id we want to modify, instead of copying the data from the original array
    //we copy the new data we want to insert.

    $newContacts = [];

    foreach ($contacts as $contactRow) {
        if ($contactRow instanceof Contact && $contactRow->getId() == $contact->getId()) {
            array_push($newContacts,$contact); //Push new value
        } else {
            array_push($newContacts,$contactRow); //Push original value
        }
    }

    return $newContacts;
}
/* U04
function updateContact(array $contact, array $contacts) : array {
    //We go through the original array and for each row we insert it into a new array.
    //When we find the id we want to modify, instead of copying the data from the original array 
    //we copy the new data we want to insert.

    $newContacts = [];

    foreach ($contacts as $contactRow) {
        if ($contactRow['id'] == $contact['id']) {
            array_push($newContacts,$contact); //Push new value
        } else {
            array_push($newContacts,$contactRow); //Push original value
        }
    }

    return $newContacts;
}
*/


//We use the similar code that the exercice4 of prac03 to make a generic table
function generateTable (array $data, array $header) : string {
    $txtTableStyle = "<style>\ntable, th, td {\nborder: 1px solid black;\nborder-collapse: collapse; margin: 0 auto; padding: 0 20px; }\n</style>";
    $txtTableBegin = "<table>\n";
    $txtTableHeader = "";
    $txtTableBody = "";
    $txtTableEnd = "</table>";

    // First make the header of the table
    $txtTableHeader = makeTableHeader($header);

    // Second make de body of the table
    $txtTableBody = makeTableData($data);

    return $txtTableStyle . $txtTableBegin . $txtTableHeader . $txtTableBody . $txtTableEnd; 
}


function makeTableHeader(array $header) : string {
    $txtHeader = "<tr style='background-color: rgb(255, 255, 200);'>\n";

    foreach($header as $value) {
        $txtHeader = $txtHeader."<th>$value</th>\n";
    }

    $txtHeader = $txtHeader."</tr>\n";
    
    return $txtHeader;

}

function makeTableData(array $data) : string {
    $txtBody = "";

    foreach($data as $row) {

        $txtBody = $txtBody."<tr>\n";

        //Add the button column
        $txtBody = $txtBody . '<td style="background-color: rgb(255, 255, 200);"><input type="submit" class="btnGreen" name="edit' . $row["id"] . '" value="Edit/View"/></td>';

        //Add the rest of the values
        foreach ($row as $value) {
            $txtBody = $txtBody . "<td>$value</td>\n";
        }

        $txtBody = $txtBody."</tr>\n";
    }

    return $txtBody;
}


