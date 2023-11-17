<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && (filter_input(INPUT_POST, "save"))) save();

$tech = ["C", "CPP", "Java", "C#", "Html", "CSS", "XML", "PHP", "JavaScript"];

function save() {
    $file = fopen("survey.txt", "r+") or die("Unable to open file");

//    $techs = filter_input(INPUT_POST, "techs");
     if (!isset($_POST["techs"])) {
        die("Niepoprawne dane");
    }

    $techs = $_POST["techs"];

    if ($techs === false || $techs === NULL)
        die("Niepoprawne dane");

    if (filesize("survey.txt")) {
        $lines = explode("\n", fread($file, filesize("survey.txt")));
        array_pop($lines);
    }
    else
        $lines = [];

    $results = [];
    foreach ($lines as $line) {
        $lang = explode(":", $line)[0];
        $count = explode(":", $line)[1];
        $results[$lang] = $count;
    }

    foreach ($techs as $tech)
        if (isset($results[$tech]))
            $results[$tech]++;
        else
            $results[$tech] = 1;

    ftruncate($file, 0);
    rewind($file);

    foreach ($results as $lang => $count)
        fwrite($file, "$lang:$count\n");

    fclose($file);

    header("location:survey.php?res");
}


function showResults() {
    $file = fopen("survey.txt", "r") or die("Unable to open file");

    $lines = explode("\n", fread($file, filesize("survey.txt")));
    array_pop($lines);

    print("<h2>Wyniki: </h2>");

    foreach ($lines as $line) {
        $data = explode(":", $line);
        print("$data[0]: $data[1]<br>");
    }

    fclose($file);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/form.css" type="text/css"/>
    <title></title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["results"])) {
    showResults();
} else {
    print ('<form id="form" action="survey.php" method="post">');
    print('<h5>Wybierz technologie, które znasz: </h5>');

    foreach ($tech as $ele) {
        print("<input id= '$ele' value='$ele' type='checkbox' name='techs[]'/><label for='$ele'>$ele</label><br>");
    }

    print('<br>');
    print('<input class="button" name="save" type="submit" id="save" value="Zapisz"/>');
    print('<input class="button" name="results" type="submit" id="results" value="Wyniki"/>');
    print('</form><br><br>');
}

?>
</form>
</body>
</html>
