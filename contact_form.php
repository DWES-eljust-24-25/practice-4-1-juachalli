<?php
// In this script do the self-validated form

$contacts = require_once __DIR__.'/data.php';    
require_once __DIR__ . "/functions.php";        

session_start();

$contact = []; //Array to store the form data
$errors = []; //Array to store the error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Store form data into array $contact
    $contact["id"] = $_POST["id"];
    $contact["title"] = $_POST["title"];
    $contact["firstname"] = trim(strip_tags($_POST["firstname"])); 
    $contact["surname"] = trim(strip_tags($_POST["surname"])); 
    $contact["birthdate"] = trim(strip_tags($_POST["birthdate"]));  
    $contact["phone"] = trim(strip_tags($_POST["phone"])); 
    $contact["email"] = trim(strip_tags($_POST["email"])); 
    $contact["favourite"] = isset($_POST["favourite"]) ? true : false;
    $contact["important"] = isset($_POST["important"]) ? true : false;
    $contact["archived"] = isset($_POST["archived"]) ? true : false;


    $_SESSION['contact'] = $contact;


    if (isset($_POST['save'])) {
        $errors = validateContact($contact); 
        empty($errors) ? header("Location:checkdata.php") : '';
    }

    if (isset($_POST['update'])) {
        //At the moment it is disabled and nothing is done
    }

    if (isset($_POST['delete'])) {
        //At the moment it is disabled and nothing is done
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

<h1>Contact</h1>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
    <label for="id">ID</label>
    <input type="text" id="id" name="id" value="<?= $contact['id'] ?? 0 ?>" readonly><br>
    <span class="error"><?= $errors['id'] ?? '' ?></span> <br>

    <label>Title</label><br>

    <input type="radio" id="mr" name="title" value="Mr." <?= ($contact['title'] ?? 'Mr.') == 'Mr.' ? 'checked' : '' ?>>
    <label for="mr">Mr.</label>
    <input type="radio" id="mrs" name="title" value="Mrs." <?= ($contact['title'] ?? 'Mr.') =='Mrs.' ? 'checked' : '' ?>>
    <label for="mrs">Mrs.</label>
    <input type="radio" id="miss" name="title" value="Miss" <?= ($contact['title'] ?? 'Mr.') =='Miss' ? 'checked' : '' ?>>
    <label for="miss">Miss</label>    
    <span class="error"><?= $errors['title'] ?? '' ?></span> <br>

    <label for="firstname">First name</label>
    <input type="text" id="firstname" name="firstname" value="<?= $contact['firstname'] ?? '' ?>">
    <label for="surname">Surname</label>
    <input type="text" id="surname" name="surname" value="<?= $contact['surname'] ?? '' ?>"><br>
    <span class="error"> <?= $errors['firstname'] ?? '' ?> </span>
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
 

    <input type="submit" name="save" value="Save" />
    <input type="submit" name="update" value="Update" disabled/>
    <input type="submit" name="delete" value="Delete" disabled/>
</form>

</body>
</html>
