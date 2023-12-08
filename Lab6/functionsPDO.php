<?php
include_once "DatabasePDO.php";

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


    if ($errors)
        die("<br>Niepoprawnie dane: " . $errors);

    return $validated;
}

function addToDbPDO($db) {
    $valid_data = validate();

    $sql = "INSERT INTO klienci (Nazwisko, Wiek, Panstwo, Email, Zamowienie, Platnosc) VALUES (";
    $sql .= "'" . $valid_data["last-name"] . "', ";
    $sql .= "'" . $valid_data["age"] . "', ";
    $sql .= "'" . $valid_data["country"] . "', ";
    $sql .= "'" . $valid_data["email"] . "', ";
    $sql .= "'" . implode(",", $valid_data["courses"]) . "', ";
    $sql .= "'" . $valid_data["payment-method"] . "'";
    $sql .= ");";

    if (!$db->insert($sql))
        print("Dodawanie do bazy danych nie powiodło się: <br>" . $db->getDbHandle()::errorInfo()[2] . "<br>");
}

function showFromDbPDO($db) {
    $sql = "SELECT * FROM klienci";
    $res = $db->select($sql, ["Nazwisko", "Wiek", "Panstwo", "Email", "Zamowienie", "Platnosc"]);

    if (!$res) {
        print("Wyszukiwnaie nie powiodło się: <br>" . $db->getDbHandle()::errorInfo()[2] . "<br>");
        return;
    }

    foreach ($res->fetchAll(PDO::FETCH_NUM) as $row){
        foreach ($row as $value){
            print("$value, ");
        }
        print("<br>");
    }
}

function showFilteredFromDbPDO($db, $filter) {
    $sql = "SELECT * FROM klienci 
                    WHERE Zamowienie LIKE '%$filter%'";
    $res = $db->select($sql, ["Nazwisko", "Wiek", "Panstwo", "Email", "Zamowienie", "Platnosc"]);
    if (!$res) {
        print("Wyszukiwnaie nie powiodło się: <br>" . $db->getDbHandle()::errorInfo()[2] . "<br>");
        return;
    }

    foreach ($res->fetchAll(PDO::FETCH_NUM) as $row){
        foreach ($row as $value){
            print("$value, ");
        }
        print("<br>");
    }
}

function showStatsFromDbPDO($db) {
    $sql = "SELECT * FROM klienci";

    $res = $db->select($sql, ["Nazwisko", "Wiek", "Panstwo", "Email", "Zamowienie", "Platnosc"]);
    if (!$res) {
        print("Wyszukiwnaie nie powiodło się: <br>" . $db->getDbHandle()::errorInfo()[2] . "<br>");
        return;
    }

    $data = "";
    foreach ($res->fetchAll(PDO::FETCH_NUM) as $row) {
        array_shift($row);
        foreach ($row as $value){
            $data .= $value . ", ";
        }
        $data .= "\n";
    }


    $file_lines = explode("\n", $data);
    array_pop($file_lines);

    $age_less_18_count = 0;
    $age_more_or_eq_50_count = 0;
    foreach ($file_lines as $line) {
        $age = explode(",", stripslashes($line))[1];
        if ($age < 18)
            $age_less_18_count++;
        elseif ($age >= 50)
            $age_more_or_eq_50_count++;
    }

    print("Liczba wszystkich zamówień: " . count($file_lines) . "<br>");
    print("Liczba zamówień od osób w wieku < 18 lat: $age_less_18_count<br>");
    print("Liczba zamówień od osób w wieku >= 50 lat: $age_more_or_eq_50_count<br>");
}
