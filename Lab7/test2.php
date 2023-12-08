<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
include_once("classes/User.php");
session_start();

print("session_id: " . session_id() . "<br><br>");

print("_SESSION: <br>");
foreach ($_SESSION as $ele)
    print("&nbsp&nbsp&nbsp&nbsp" . $ele . "<br>");
print("<br><br>");

$user = unserialize($_SESSION["user"]);
$user->show();
print("<br>");

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();

print("<a href='test1.php'>test1.php</a>");
?>
</body>