
<?php
//This script is to show the validated data from contact.php

session_start();

if (isset($_SESSION['contact'])) {

    echo "<h1>“No errors!”</h1>";

    $contact = $_SESSION['contact'];

    echo"<hr>";

    echo "<p><b><u>Contact data</u></b></p>";
    echo "<p>ID: " . $contact['id'] . "</p>";
    echo "<p>Title: " . $contact['title'] . "</p>";
    echo "<p>First Name: " . $contact['firstname'] . "</p>";
    echo "<p>Surname: " . $contact['surname'] . "</p>";
    echo "<p>Birth Date: " . $contact['birthdate'] . "</p>";
    echo "<p>Phone: " . $contact['phone'] . "</p>";
    echo "<p>E-mail: " . $contact['email'] . "</p>";
    echo "<p>Type Favourite: " . ($contact['favourite'] ? 'OK' : '-') . "</p>";
    echo "<p>Type Important: " . ($contact['important'] ? 'OK' : '-') . "</p>";
    echo "<p>Type Archived: " . ($contact['archived'] ? 'OK' : '-') . "</p>";
    
} else {

    echo "<p>No contact data</p>";
    
}

session_destroy();

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



    
</body>
</html>

