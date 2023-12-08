<head>
    <link rel="stylesheet" href="CSS/form.css" type="text/css"/>
    <title></title>
</head>

<?php
include_once("classes/User.php");
include_once("classes/RegistrationForm.php");
include_once("classes/Database.php");

$rf = new RegistrationForm();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $user = $rf->checkUser();
    if ($user === NULL)
        print("<p>Niepoprawne dane rejestracji.</p>");
    else {
        $db = new Database("127.0.0.1", "admin", "admin", "klienci");
        print("<p>Poprawne dane rejestracji:</p>");

        $user->saveDB($db);

        print ("Users: ");
        User::getAllUsersFromDB($db);
    }
}
