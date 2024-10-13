<?php
//This script is to show the validated data from contact.php
declare(strict_types=1);

require_once __DIR__ . "/functions.php"; 

session_start();

if (isset($_SESSION['contact'])) {

    $contact = $_SESSION['contact'];

    //We get the array of contacts we are working with, stored en a session variable named "contacts"
    //If we have one already defined, we use it
    //If we don't have any, we use the original array from "data.php"
    $contacts = isset($_SESSION['contacts']) ? $_SESSION['contacts'] : require_once __DIR__.'/data.php';
    
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //With the id value we check if it is a new registration or an update
    if (isset($_POST['save'])) {
        $_SESSION['contacts'] = ($contact['id'] ?? '') == '' ? addContact($contact,$contacts) : updateContact($contact,$contacts);
        header("Location:contact_list.php");
    }

    if (isset($_POST['cancel'])) {
        header("Location:contact_list.php");
    }
 
} 

include __DIR__ . '/parts/head.part.php';
include __DIR__ . '/parts/header.part.php';

?>

    <form method="post" action="<?php $_SERVER["PHP_SELF"];?>">
        <?=isset($_SESSION['contact']) ? "<h1>No errors!</h1>" : "<h1>No contact data</h1>"?>
        <div>
        <p><b>=> <u><?= ($contact['id'] ?? '') == '' ? 'NEW Contact data' : 'UPDATE Contact data' ?></u> <=</b></p>            
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
    
<?php include __DIR__ . '/parts/footer.part.php'; ?>
