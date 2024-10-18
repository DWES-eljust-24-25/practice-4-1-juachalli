<?php
// In this script do the self-validated form
declare(strict_types=1);

require_once __DIR__.'/../partials/main.php';

session_start();

//We get the array of contacts we are working with, stored en a session variable named "contacts"
//If we have one already defined, we use it
//If we don't have any, we use the original array from "data.php"
$contacts = $_SESSION['contacts'] ?? loadContacts();

$contact = new Contact(); //Object Contact to store the form data

$errors = []; //Array to store the error messages

//If we have an 'id' parameter passed by GET, we retrieve the data of that Id as contact if exist in $contacts
if (isset($_GET['id'])) {
    $contact = getContact((int)$_GET['id'],$contacts);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //If we come from a POST call, we create a contact from that form data
    $contact->setId((int)$_POST["id"]);
    $contact->setTitle($_POST["title"]);
    $contact->setName(trim(strip_tags($_POST["name"])));
    $contact->setSurname(trim(strip_tags($_POST["surname"])));
    $contact->setBirthdate(trim(strip_tags($_POST["birthdate"])));
    $contact->setphone(trim(strip_tags($_POST["phone"])));
    $contact->setEmail(trim(strip_tags($_POST["email"])));
    $contact->setFavourite(isset($_POST["favourite"]));
    $contact->setImportant(isset($_POST["important"]));
    $contact->setArchived(isset($_POST["archived"]));

    //We save the contact data in a session variable named "contact"
    $_SESSION['contact'] = $contact;
    $_SESSION['contacts'] = $contacts;

    if (isset($_POST['save'])) {
        $errors = $contact->validate();//validateContact($contact);
        empty($errors) ? header("Location:checkdata.php") : '';
    }

    if (isset($_POST['update'])) {
        $errors = $contact->validate();//validateContact($contact);
        empty($errors) ? header("Location:checkdata.php") : '';
    }

    if (isset($_POST['delete'])) {
        //At the moment it is disabled and nothing is done
    }
 
} 


// Call the function that return number of days until the birthday
$daysUntilBirthday = $contact->checkBirthday(); 
$messageUntilBirthday = "";

 // If $daysUntilBirthday is null, it means that they have passed the date wrong in the parameter.
if (is_numeric($daysUntilBirthday)) {

	if ($daysUntilBirthday == 0) {
        $messageUntilBirthday = " Today is " . $contact->getName() . "'s birthday. Congratulations!!";
	} else {
		if ($daysUntilBirthday > 0 && $daysUntilBirthday <= 7) {
			$messageUntilBirthday = " There are " . $daysUntilBirthday . " days left for " . $contact->getName() . "'s birthday!!";
		} else {
			//$messageUntilBirthday = " => There are " . $daysUntilBirthday . " days away for " . $contact->getName() . "'s birthday!!.... is not close!! <=";
		}
	}

} else {
	//// If the Birthday date is not correct
	//$messageUntilBirthday = "We have not been able to get the days until the birthday";
}



include_once __DIR__ . '/../partials/head.php';
include_once __DIR__ . '/../partials/header.php';


?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <hr>
    <h1>Contact</h1>
    <hr>
    <div>
        <label for="id">ID</label>
        <input type="text" id="id" name="id" value="<?= $contact->getId() ?>" readonly><br>
        <span class="error"><?= $errors['id'] ?? '' ?></span> <br>

        <label>Title</label><br>

        <input type="radio" id="mr" name="title" value="Mr." <?= $contact->getTitle() == 'Mr.' ? 'checked' : '' ?>>
        <label for="mr">Mr.</label>
        <input type="radio" id="mrs" name="title" value="Mrs." <?= $contact->getTitle() =='Mrs.' ? 'checked' : '' ?>>
        <label for="mrs">Mrs.</label>
        <input type="radio" id="miss" name="title" value="Miss" <?= $contact->getTitle() =='Miss' ? 'checked' : '' ?>>
        <label for="miss">Miss</label>
        <span class="error"><?= $errors['title'] ?? '' ?></span> <br>
        <br>
        <label for="name">First name</label>
        <input type="text" id="name" name="name" value="<?= $contact->getName() ?>">
        <label for="surname">Surname</label>
        <input type="text" id="surname" name="surname" value="<?= $contact->getSurname() ?>"> <br>
        <span class="error"> <?= $errors['name'] ?? '' ?> </span>
        <span class="error"> <?= $errors['surname'] ?? '' ?> </span> <br>

        <label for="birthdate">Birth date</label>
        <input type="date" id="birthdate" name="birthdate" value="<?= $contact->getBirthdate() ?>"> <?= $messageUntilBirthday ?> <br>
        <span class="error"> <?= $errors['birthdate'] ?? '' ?> </span> <br>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?= $contact->getPhone() ?>"> <br>
        <span class="error"> <?= $errors['phone'] ?? '' ?> </span> <br>

        <label for="email">E-mail</label>
        <input type="text" id="email" name="email" value="<?= $contact->getEmail() ?>"> <br>
        <span class="error"> <?= $errors['email'] ?? '' ?> </span> <br>

        <label>Type</label><br>
        <input type="checkbox" name="favourite" value="Favourite" <?= $contact->getFavourite() ? 'checked' : '' ?>>
        <label for="favourite">Favourite</label><br>
        <input type="checkbox" name="important" value="Important" <?= $contact->getImportant() ? 'checked' : '' ?>>
        <label for="important">Important</label><br>
        <input type="checkbox" name="archived" value="Archived" <?= $contact->getArchived() ? 'checked' : '' ?>>
        <label for="archived">Archived</label><br><br>
    </div>
    <div>
        <!--We use then $contact['id'] value for enable o disable buttons-->
        <input type="submit" class="btnGreen<?= $contact->getId() == 0 ? '' : 'Disabled' ?>" name="save" value="Save" <?= $contact->getId() == 0 ? '' : 'disabled' ?>/>
        <input type="submit" class="btnGreen<?= $contact->getId() == 0 ? 'Disabled' : '' ?>" name="update" value="Update" <?= $contact->getId() == 0 ? 'disabled' : '' ?>/>
        <input type="submit" class="btnRedDisabled" name="delete" value="Delete" disabled/> <!--In this practice we won’t use the Delete button-->
    </div>
    <div>
        <p><a href="../index.php">Back to main page</a></p>
    </div>
</form>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>

