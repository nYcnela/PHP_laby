<?php
$courses = ["C", "CPP", "Java", "C#", "HTML", "CSS", "XML", "PHP", "JavaScript"];
include_once "functions.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/form.css" type="text/css"/>
    <title></title>
</head>


<body>
<form id="form" action="files.php" method="post">
    <label for="last-name" class="text-box">Nazwisko:</label><input id="last-name" type="text" name="last-name"/><br/>
    <label for="age" class="text-box">Wiek:</label><input id="age" type="number" name="age"/><br/>
    <label for="country" class="text-box">Państwo:</label>
    <select id="country" name="country">
        <option value="poland">Polska</option>
    </select><br/>
    <label for="email" class="text-box">Adres e-mail:</label><input id="email" type="email" name="email" placeholder="mail@host.domain"/><br/>
    <h5>Zamawiam tutorial z języka: </h5>

    <?php
    foreach ($courses as $course) {
        echo "<input id= '$course' value='$course' type='checkbox' name='courses[]'/><label for='$course'>$course</label>";
    }
    ?>

    <h5>Sposób zapłaty: </h5>
    <input id="eurocard" type="radio" name="payment-method" value="eurocard"/><label for="eurocard">eurocard</label>
    <input id="visa" type="radio" name="payment-method" value="visa"/><label for="visa">visa</label>
    <input id="transfer" type="radio" name="payment-method" value="transfer"/><label for="transfer">przelew
        bankowy</label><br/>

    <input class="button" name="clear" type="reset" id="clear" value="Wyczyść"/>
    <input class="button" name="save" type="submit" id="save" value="Zapisz"/>
    <input class="button" name="show" type="submit" id="show" value="Pokaż"/>
    <input class="button" name="php-button" type="submit" id="php-button" value="PHP"/>
    <input class="button" name="cpp-button" type="submit" id="cpp-button" value="CPP"/>
    <input class="button" name="java-button" type="submit" id="java-button" value="Java"/>

    <br><br>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["save"])) {
            add();
        }
        else if (isset($_POST["show"])) {
            show();
        }
        else if (isset($_POST["php-button"])) {
            show_filtered("PHP");
        }
        else if (isset($_POST["cpp-button"])) {
            show_filtered("CPP");
        }
        else if (isset($_POST["java-button"])) {
            show_filtered("Java");
        }
    }

    print "<br><br>";

    foreach(array_keys($_SERVER) as $item){
        print "$item: ";
        if(is_array($_SERVER[$item])){
            print "<br/>";
            foreach($_SERVER[$item] as $arr_element){
                print " - $arr_element<br/>";
            }
        }else{
            print "$_SERVER[$item]<br/>";
        }
    }
    

    ?>
</form>
</body>
</html>