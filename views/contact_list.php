<?php
//In this script, do the contact list table
declare(strict_types=1);

require_once __DIR__.'/../partials/main.php';

session_start();

//We get the array of contacts we are working with, stored en a session variable named "contacts"
//If we have one already defined, we use it
//If we don't have any, we use the original array from "data.php"
$contacts = isset($_SESSION['contacts']) ? $_SESSION['contacts'] : loadContacts();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //We click new => we go to the contact_form without parameters to create a new contact
    if (isset($_POST['new'])) {
        header("Location:contact_form.php");
    }

    //We press edit/view => we go through all the contacts to find the one that has been pressed
    $idPresed=0;
    foreach ($contacts as $contactRow) {
        if (isset($_POST['edit' . $contactRow->getId()])) {
            $idPresed = $contactRow->getId();
        }
        header("Location: contact_form.php?id=" . $idPresed);
    }
} 

include_once __DIR__ . '/../partials/head.php';
include_once __DIR__ . '/../partials/header.php';

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <hr>
    <h1>Contact List</h1>
    <hr>
    <div style="text-align:center;">
        <input type="submit" class="btnGreen" name="new" value="Create new contact"/>
    </div>
    <div>
        <?php    
            //We define the header table
            $headerTable = array("","ID","Title","Name","Surname");
    
            //We define the values ​​of the contacts we want to display
            $dataTable=[];
            foreach($contacts as $contact) {
                array_push($dataTable,array("id" => $contact->getId(),
                                            "title" => $contact->getTitle(),
                                            "name" => $contact->getName(),
                                            "surname" => $contact->getSurname()));
            }

            //We call de showTable function to generate the html table
            echo generateTable($dataTable,$headerTable);
            
            //It is not requested in practice but we take advantage of it
            //to display the data using the method Contact__toString()
            echo "<br><hr><br>";
            echo "<p><b><u>Another way to present the contact list<br>using the Contact__toString() method</u></b></p>";
            echo "<hr>";

            foreach($contacts as $contact) {
                //echo "<div><p>" . $contact->__toString() . "</p></div>";
                echo "<div><div><p><button name='edit" . $contact->getId() . "'>" . $contact->__toString() . "</button></p></div></div>";
            }
        ?> 
    </div>
    <div>
        <p><a href='../index.php'>Back to main page</a></p>
    </div>
</form>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
