<?php 
require_once __DIR__. '/partials/main.php';
include_once __DIR__ .'/partials/head.php';
include_once __DIR__ .'/partials/header.php'; 

?>

    <form>
        <div>
            <hr>
            <h1>Practice DWES - Contact App</h1>
            <hr>
            <br>
            This practice consists of the first of a series of practices, consisting of a Contacts application.<br>
            Each practice will be based on the previous one.<br>
            To start, clone the repository task as explained in the end of the practice.<br>
            <p></p>
            The inclusion of comments in the scripts will be valued.<br>
            <p></p>
            Once done, do the submission via GitHub Classroom as detailed in the end of the practice.<br>
            <p></p>
            <hr>
        </div>
        <div>
            <hr>
            <h1>Main menu</h1>
            <p><a href="./views/contact_form.php">Create a new contact</a></p>
            <p><a href="./views/contact_list.php">View contact list</a></p>
            <hr>
        </div>        
    </form>

<?php include_once __DIR__ . '/partials/footer.php'; ?>
