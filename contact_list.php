<?php
//In this script, do the contact list table
declare(strict_types=1);

//$contacts = require_once __DIR__.'/data.php';
require_once __DIR__ . "/functions.php";        

session_start();

//We get the array of contacts we are working with, stored en a session variable named "contacts"
//If we have one already defined, we use it
//If we don't have any, we use the original array from "data.php"
$contacts = isset($_SESSION['contacts']) ? $_SESSION['contacts'] : require_once __DIR__.'/data.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //We click new => we go to the contcat_form without parameters to create a new contact
    if (isset($_POST['new'])) {
        header("Location:contact_form.php");

    }

    //We press edit/view => we go through all the contacts to find the one that has been pressed
    $idPresed=0;
    foreach ($contacts as $contactRow) {
        if (isset($_POST['edit' . $contactRow['id']])) {
            $idPresed = $contactRow['id'];
        }
        header("Location: contact_form.php?id=" . $idPresed);
    }
} 

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

<h1>Contact List</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div>
        <input type="submit" class="btnGreen" name="new" value="Create new contact"/>
    </div>
    <div>
        <?php    
            //$headerTable = array("","ID","Title","Name","Surname");
            //$bodyTable = [];
            //echo showTable($bodyTable,$headerTable);
            echo "<br>";    
            foreach ($contacts as $contactRow) {
            print_r ($contactRow);
        ?> 
        <input type="submit" class="btnGreen" name="edit<?= $contactRow['id'] ?>" value="Edit/View"/>

        <?php 
            echo "<hr>";
            }
        ?>
    </div>
    <div>
        <p><a href="index.html">Back to main page</a></p>
    </div>
</form>

</body>
</html>
