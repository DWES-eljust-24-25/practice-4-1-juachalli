<?php
//This script is to show the validated data from contact.php
declare(strict_types=1);

require_once __DIR__ . "/functions.php"; 

session_start();

if (isset($_SESSION['contact'])) {

    echo "<h1>“No errors!”</h1>";

    $contact = $_SESSION['contact'];

    //We get the array of contacts we are working with, stored en a session variable named "contacts"
    //If we have one already defined, we use it
    //If we don't have any, we use the original array from "data.php"
    $contacts = isset($_SESSION['contacts']) ? $_SESSION['contacts'] : require_once __DIR__.'/data.php';
    
} else {

    echo "<h1>No contact data</h1>";

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //With the id value we check if it is a new registration or an update
    if (isset($_POST['save'])) {
        $_SESSION['contacts'] = ($contact['id'] ?? '') == '' ? addContact($contact,$contacts) : updateContact($contact,$contacts);
        header("Location:contact_list.php");
    }

    if (isset($_POST['cancel'])) {
        header("Location:index.html");
    }
 
} 


//session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact App</title>	
    <meta charset="UTF-8">
    <meta name="author" content="Salvador Chaveli (juachalli)">
    <meta name="description" content="Unit 04. PHP and Forms - Practice">
    <link rel="stylesheet" type="text/css" href="./main.css">    
</head>

<body>
    <form method="post" action="<?php $_SERVER["PHP_SELF"];?>">
        <p><b>=> <u><?= ($contact['id'] ?? '') == '' ? 'NEW Contact data' : 'UPDATE Contact data' ?></u> <=</b></p>
        <div>
        <p><b>ID:</b> <?=$contact['id'] ?? ''?> </p>
        <p><b>Title:</b> <?=$contact['title'] ?? '' ?> </p>
        <p><b>First Name:</b> <?=$contact['name'] ?? '' ?> </p>
        <p><b>Surname:</b> <?=$contact['surname'] ?? '' ?> </p>
        <p><b>Birth Date:</b> <?=$contact['birthdate'] ?? '' ?> </p>
        <p><b>Phone:</b> <?=$contact['phone'] ?? '' ?> </p>
        <p><b>E-mail:</b> <?=$contact['email'] ?? '' ?> </p>
        <p><b>Type Favourite:</b> <?=($contact['favourite'] ?? '') == '' ? 'No' : "Yes" ?> </p>
        <p><b>Type Important:</b> <?=($contact['important'] ?? '') == '' ? 'No' : "Yes" ?> </p>
        <p><b>Type Archived:</b> <?=($contact['archived'] ?? '') == '' ? 'No' : "Yes" ?> </p>
        </div>
        <div>
            <input type="submit" class="btnGreen" name="save" value="<?= ($contact['id'] ?? '') == '' ? 'Confirm NEW contact' : 'Confirm UPDATE contact' ?>"/>
            <input type="submit" class="btnRed" name="cancel" value="<?= ($contact['id'] ?? '') == '' ? 'Cancel NEW contact' : 'Cancel UPDATE contact' ?>"/>
        </div>
    </form>
    
</body>
</html>
