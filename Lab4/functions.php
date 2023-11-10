<?php

$dane_txt = $_SERVER['DOCUMENT_ROOT'] . '/../Lab3/dane.txt';


function validate() {
    $args = [
        "last-name" => [
            "filter" => FILTER_VALIDATE_REGEXP,
            "options" => ["regexp" => "/^[A-Z]{1}[a-ząęłńśćźżó-]{1,25}$/"]],
        "age" => FILTER_SANITIZE_NUMBER_INT,
        "country" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        "email" => FILTER_VALIDATE_EMAIL,
        "courses" => [
            "filter" => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            "flags" => FILTER_REQUIRE_ARRAY],
        "payment-method" => FILTER_SANITIZE_STRING
    ];

    $validated = filter_input_array(INPUT_POST, $args);
    echo "<p><b?>Dodawanie do pliku:</b></p>";
    var_dump($validated);

    $errors = "";
    foreach ($validated as $key => $val) {
        if ($val === false or $val === NULL) {
            $errors .= $key . " ";
            continue;
        }
        if ($key == "courses")
            foreach ($val as $i => $lang)
                $validated[$key][$i] = addcslashes($lang, "\\,");
        else
            $validated[$key] = addcslashes($val, "\\,");
    }


    if (!$errors)
        return $validated;
    else
        die("<br>Niepoprawnie dane: " . $errors);

}


function add() {
    $file = fopen("dane.txt", "a") or die("Nie mozna otworzyc pliku");

    $valid_input = validate();
    $data = "";

    $data .= $valid_input["last-name"] . ", ";
    $data .= $valid_input["age"] . ", ";
    $data .= $valid_input["country"] . ", ";
    $data .= $valid_input["email"] . ", ";
    $data .= "[" . implode(", ", $valid_input["courses"]) . "]" . ", ";
    $data .= $valid_input["payment-method"];
    $data .= PHP_EOL;

    fwrite($file, $data);
    fclose($file);
}

function show() {
    $file = fopen("dane.txt", "r") or die("Unable to open file");
    print str_replace("\n", "<br>", fread($file, filesize("dane.txt")));
    fclose($file);
}

function showFiltered($language) {
    $file = fopen("dane.txt", "r") or die("Unable to open file");
    while (($line = fgets($file)) !== false) {
        if (strpos($line, $language) !== false) {
            print $line . "<br>";
        }
    }
    fclose($file);
}