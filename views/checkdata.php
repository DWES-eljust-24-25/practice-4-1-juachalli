<?php
//This script is to show the validated data from contact.php
declare(strict_types=1);

require_once __DIR__.'/../partials/main.php';

session_start();

if (isset($_SESSION['contact'])) {

    $contact = $_SESSION['contact'];

    //We get the array of contacts we are working with, stored en a session variable named "contacts"
    //If we have one already defined, we use it
    //If we don't have any, we use the original array from "data.php"
    $contacts = $_SESSION['contacts'] ?? loadContacts();
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //With the id value we check if it is a new registration or an update
    if (isset($_POST['save'])) {
        $_SESSION['contacts'] = $contact->getId() == 0 ? addContact($contact,$contacts) : updateContact($contact,$contacts);
        header("Location:contact_list.php");
    }

    if (isset($_POST['cancel'])) {
        header("Location:contact_list.php");
    }
 } 

include_once __DIR__ . '/../partials/head.php';
include_once __DIR__ . '/../partials/header.php';

?>

    <form method="post" action="<?php $_SERVER["PHP_SELF"];?>">
        <?=isset($_SESSION['contact']) ? "<h1>No errors!</h1>" : "<h1>No contact data</h1>"?>
        <div>
        <p><b>=> <u> <?= $contact->getId() == 0 ? 'NEW Contact data' : 'UPDATE Contact data' ?> </u> <=</b></p>            
        <p><b>ID: </b> <?= $contact->getId() ?> </p>
        <p><b>Title: </b> <?= $contact->getTitle() ?> </p>
        <p><b>First Name: </b> <?= $contact->getName() ?> </p>
        <p><b>Surname: </b> <?= $contact->getSurname() ?> </p>
        <p><b>Birth Date: </b> <?= $contact->getBirthdate() ?> </p>
        <p><b>Phone: </b> <?= $contact->getPhone() ?> </p>
        <p><b>E-mail: </b> <?= $contact->getEmail() ?> </p>
        <p><b>Type Favourite: </b> <?= $contact->getFavourite() ? 'Yes' : "No" ?> </p>
        <p><b>Type Important: </b> <?= $contact->getImportant() ? 'Yes' : "No" ?> </p>
        <p><b>Type Archived: </b> <?= $contact->getArchived() ? 'Yes' : "No" ?> </p>
        </div>
        <div>
            <input type="submit" class="btnGreen" name="save" value="<?= $contact->getId() == 0 ? 'Confirm NEW contact' : 'Confirm UPDATE contact' ?>"/>
            <input type="submit" class="btnRed" name="cancel" value="<?= $contact->getId() == 0 ? 'Cancel NEW contact' : 'Cancel UPDATE contact' ?>"/>
        </div>
    </form>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
