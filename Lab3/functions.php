<?php

$dane_txt = $_SERVER['DOCUMENT_ROOT'] . '/../Lab3/dane.txt';


function add() {
    $file = fopen("dane_txt", "a") or die("Unable to open file");

    $data = "";
    $data .= "Nazwisko: " . htmlspecialchars(trim($_POST["last-name"])) . ", ";
    $data .= "Wiek: " . htmlspecialchars(trim($_POST["age"])) . ", ";
    $data .= "Panstwo: " . htmlspecialchars(trim($_POST["country"])) . ", ";
    $data .= "Email: " . htmlspecialchars(trim($_POST["email"])) . ", ";
    $data .= "Tutoriale: [" . implode(", ", $_POST["courses"]) . "]" . ", ";
    $data .= "Metoda platnosci: " . htmlspecialchars(trim($_POST["payment-method"]));
    $data .= "\n";

    fwrite($file, $data);
    fclose($file);
}

function show() {
    $file = fopen("dane_txt", "r") or die("Unable to open file");
    print str_replace("\n", "<br>", fread($file, filesize("dane_txt")));
    fclose($file);
}

function show_filtered($language) {
    $file = fopen("dane_txt", "r") or die("Unable to open file");
    while (($line = fgets($file)) !== false) {
        if (strpos($line, $language) !== false) {
            print $line . "<br>";
        }
    }
    fclose($file);
}