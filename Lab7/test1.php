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
$_SESSION["user"] = serialize(new User("kp", "Kubus Puchatek", "kubus@stumilowylas.pl", "nielubietygryska"));


print("session_id: " . session_id() . "<br><br>");

print("_SESSION: <br>");
foreach ($_SESSION as $ele)
    print("&nbsp&nbsp&nbsp&nbsp" . $ele . "<br>");
print("<br><br>");

print("_COOKIE: <br>");
foreach ($_COOKIE as $ele)
    print("&nbsp&nbsp&nbsp&nbsp" . $ele . "<br>");
print("<br><br>");

print("<a href='test2.php'>test2.php</a>");
?>
</body>