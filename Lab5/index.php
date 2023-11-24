<head>
    <link rel="stylesheet" href="CSS/form.css" type="text/css"/>
    <title></title>
</head>

<?php
include_once("classes/User.php");
include_once("classes/RegistrationForm.php");

$user1 = new User ("kp", "Kubus Puchatek", "kubus@stumilowylas.pl", "nielubietygryska");
$user1->show();
print("<br>");

$user2 = new User ("aaaaa", "Bbbbb Ccccc", "dddddd@eeee.ff", "gggggggg");
$user2->show();
print("<br>");

$user1->setStatus($user1::STATUS_ADMIN);
$user1->show();
print("<br><br><br>");

print ("JSON: ");
User::getAllUsers("users.json");
print ("XML: ");
User::getAllUsersFromXML("users.xml");
print("<br><br><br>");


$rf = new RegistrationForm();
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $user = $rf->checkUser();
    if ($user === NULL)
        print("<p>Niepoprawne dane rejestracji.</p>");
    else {
        print("<p>Poprawne dane rejestracji:</p>");

        $user->save("users.json");
        $user->saveXML("users.xml");

        print ("JSON: ");
        User::getAllUsers("users.json");
        print ("XML: ");
        User::getAllUsersFromXML("users.xml");
        print("<br><br><br>");

    }
}
