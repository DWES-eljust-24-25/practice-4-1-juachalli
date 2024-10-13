<?php
//In this script, place the functions
declare(strict_types=1);


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

    //phone: required and must be a valid phone number(use preg_match() and regular expresions).
    if (empty($contact["phone"])) {
        $errors["phone"] = "* Phone is required";
    } elseif (!preg_match("/^[0-9]{9}$/", $contact["phone"])) { //Validates 9-digit phone numbers
        $errors["phone"] = "* Phone has not a valid format => 9-digit phone number";
    }

    //email: required and must be a valid email(usefilter_var()).
    if (empty($contact["email"])) {
        $errors["email"] = "* E-mail is required";
    } elseif (!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "* E-mail has not a valid format => pattern name@domain.ext";
    }

    return $errors;
}


function getContact(string $id, array $contacts) : array {
    //Check if the $id parameter exits in the array $contacts parameter
    //If exists load contact data from the array
    //If do not exists return an empty array

    $contact = []; //Array to store the form data

    foreach ($contacts as $contactRow) {
    if ($contactRow['id'] == $id) {
        // Asignar valores a las variables del formulario
        return $contactRow;
        }
    }

    return array();
}
    

function addContact(array $contact, array $contacts) : array {
    //Add new contact to contacs array
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


//We use the same code that the exercice4 of prac03 to make a generic table
function showTable (array $data, ?array $header) : string {
    $txtTableStyle = "<style>\ntable, th, td {\nborder: 1px solid black;\nborder-collapse: collapse;\n}\n</style>";
    $txtTableBegin = "<table>\n";
    $txtTableHeader = "";
    $txtTableBody = "";
    $txtTableEnd = "</table>";

    // If the $header is informed, we take those values ​​to create it
    // Otherwise we use the keys from the table $data
    $header = generateHeader($data,$header);

    // First make the header of the table
    $txtTableHeader = makeGenericTableHeader($header);

    // Second make de body of the table
    $txtTableBody = makeGenericTableBody($data);

    return $txtTableStyle . $txtTableBegin . $txtTableHeader . $txtTableBody . $txtTableEnd; 
}

function generateHeader(array $data, ?array $header) : array {
    $newHeader = [];

    // We take header values from the key of $data 
    foreach($data[0] as $key => $value) {
        array_push($newHeader,$key);
    }

    // If $header have values, we update the header values
    foreach($newHeader as $key => $value) {
         $newHeader[$key] = isset($header[$key]) ? $header[$key] : $newHeader[$key];
    }

    return $newHeader;
}


function makeGenericTableHeader(array $header) : string {
    $txtHeader = "<tr>\n";

    foreach($header as $value) {
        $txtHeader = $txtHeader."<th>$value</th>\n";
    }

    $txtHeader = $txtHeader."</tr>\n";
    
    return $txtHeader;

}

function makeGenericTableBody(array $body) : string {
    $txtBody = "";

    foreach($body as $content) {

        $txtBody = $txtBody."<tr>\n";

        foreach ($content as $value) {
            $txtBody = $txtBody . "<td>$value</td>\n";
        }

        $txtBody = $txtBody."</tr>\n";
    }
    
    return $txtBody;

}
