<?php
// In this script do the self-validated form
declare(strict_types=1);

//$contacts = require_once __DIR__.'/data.php';    
require_once __DIR__ . "/functions.php";        

session_start();

//We get the array of contacts we are working with, stored en a session variable named "contacts"
//If we have one already defined, we use it
//If we don't have any, we use the original array from "data.php"
$contacts = isset($_SESSION['contacts']) ? $_SESSION['contacts'] : require_once __DIR__.'/data.php';

$contact = []; //Array to store the form data
$errors = []; //Array to store the error messages

//If we have an 'id' parameter passed by GET, we retrieve the data of that Id as contact if exist in $contacts
if (isset($_GET['id'])) {
    $contact = getContact($_GET['id'],$contacts);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //If we come from a POST call, we create a contact from that form data
    $contact["id"] = $_POST["id"];
    $contact["title"] = $_POST["title"];
    $contact["name"] = trim(strip_tags($_POST["name"])); 
    $contact["surname"] = trim(strip_tags($_POST["surname"])); 
    $contact["birthdate"] = trim(strip_tags($_POST["birthdate"]));  
    $contact["phone"] = trim(strip_tags($_POST["phone"])); 
    $contact["email"] = trim(strip_tags($_POST["email"])); 
    $contact["favourite"] = isset($_POST["favourite"]) ? true : false;
    $contact["important"] = isset($_POST["important"]) ? true : false;
    $contact["archived"] = isset($_POST["archived"]) ? true : false;

    //We save the contact data in a session variable named "contact"
    $_SESSION['contact'] = $contact;
    $_SESSION['contacts'] = $contacts;

    if (isset($_POST['save'])) {
        $errors = validateContact($contact); 
        empty($errors) ? header("Location:checkdata.php") : '';
    }

    if (isset($_POST['update'])) {
        $errors = validateContact($contact); 
        empty($errors) ? header("Location:checkdata.php") : '';
    }

    if (isset($_POST['delete'])) {
        //At the moment it is disabled and nothing is done
    }
 
} 

include __DIR__ . '/parts/head.part.php';
include __DIR__ . '/parts/header.part.php';


?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <hr>
    <h1>Contact</h1>
    <hr>
    <div>
        <label for="id">ID</label>
        <input type="text" id="id" name="id" value="<?= $contact['id'] ?? '' ?>" readonly><br>
        <span class="error"><?= $errors['id'] ?? '' ?></span> <br>

        <label>Title</label><br>

        <input type="radio" id="mr" name="title" value="Mr." <?= ($contact['title'] ?? 'Mr.') == 'Mr.' ? 'checked' : '' ?>>
        <label for="mr">Mr.</label>
        <input type="radio" id="mrs" name="title" value="Mrs." <?= ($contact['title'] ?? 'Mr.') =='Mrs.' ? 'checked' : '' ?>>
        <label for="mrs">Mrs.</label>
        <input type="radio" id="miss" name="title" value="Miss" <?= ($contact['title'] ?? 'Mr.') =='Miss' ? 'checked' : '' ?>>
        <label for="miss">Miss</label>    
        <span class="error"><?= $errors['title'] ?? '' ?></span> <br>
        <br>
        <label for="name">First name</label>
        <input type="text" id="name" name="name" value="<?= $contact['name'] ?? '' ?>">
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" value="<?= $contact['surname'] ?? '' ?>"><br>
        <span class="error"> <?= $errors['name'] ?? '' ?> </span>
        <span class="error"> <?= $errors['surname'] ?? '' ?> </span> <br>

        <label for="birthdate">Birth date</label>
        <input type="date" id="birthdate" name="birthdate" value="<?= $contact['birthdate'] ?? '' ?>"><br>
        <span class="error"> <?= $errors['birthdate'] ?? '' ?> </span> <br>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?= $contact['phone'] ?? '' ?>"><br>
        <span class="error"> <?= $errors['phone'] ?? '' ?> </span> <br>

        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" value="<?= $contact['email'] ?? '' ?>"><br>
        <span class="error"> <?= $errors['email'] ?? '' ?> </span> <br>

        <label>Type<label><br>
        <input type="checkbox" name="favourite" value="Favourite" <?= ($contact['favourite'] ?? '') == 'Favourite' ? 'checked' : '' ?>>
        <label for="favourite">Favourite</label><br>
        <input type="checkbox" name="important" value="Important" <?= ($contact['important'] ?? '') == 'Important' ? 'checked' : '' ?>>
        <label for="important">Important</label><br>
        <input type="checkbox" name="archived" value="Archived" <?= ($contact['archived'] ?? '') == 'Archived' ? 'checked' : '' ?>>
        <label for="archived">Archived</label><br><br>
    </div>
    <div>
        <!--We use then $contact['id'] value for enable o disable buttons-->
        <input type="submit" class="btnGreen<?= ($contact['id'] ?? '') == '' ? '' : 'Disabled' ?>" name="save" value="Save" <?= ($contact['id'] ?? '') == '' ? '' : 'disabled' ?>/>
        <input type="submit" class="btnGreen<?= ($contact['id'] ?? '') == '' ? 'Disabled' : '' ?>" name="update" value="Update" <?= ($contact['id'] ?? '') == '' ? 'disabled' : '' ?>/>
        <input type="submit" class="btnRedDisabled" name="delete" value="Delete" disabled/> <!--In this practice we won’t use the Delete button-->
    </div>
    <div>
        <p><a href="index.php">Back to main page</a></p>
    </div>    
</form>
    
<?php include __DIR__ . '/parts/footer.part.php'; ?>

