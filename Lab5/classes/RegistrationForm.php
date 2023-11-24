<?php

class RegistrationForm {
    private $user;

    public function __construct() {
        ?>
        <h3>Formularz rejestracji</h3>
        <form action="index.php" method="post">
            <label for="userName" class="text-box">Nazwa użytkownika:</label><input id="userName" type="text" name="userName"/><br/>
            <label for="fullName" class="text-box">Pełna nazwa użytkownika:</label><input id="fullName" type="text" name="fullName"/><br/>
            <label for="email" class="text-box">Email użytkownika:</label><input id="email" type="email" name="email"/><br/>
            <label for="passwd" class="text-box">Hasło użytkownika:</label><input id="passwd" type="password" name="passwd"/><br/>

            <input class="button" name="submit" type="submit" id="submit" value="Rejestruj">
        </form>
        <?php
    }

    public function checkUser(): ?User {
        $args = [
            "userName" => [
                "filter" => FILTER_VALIDATE_REGEXP,
                "options" => ["regexp" => "/^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/"]],
            "fullName" => FILTER_SANITIZE_STRING,
            "email" => FILTER_VALIDATE_EMAIL,
            "passwd" => FILTER_DEFAULT
        ];

        $validated = filter_input_array(INPUT_POST, $args);

        $errors = "";
        foreach ($validated as $key => $val)
            if ($val === false or $val === NULL)
                $errors .= $key . " ";

        if ($errors === "") {
            $this->user = new User(
                $validated["userName"],
                $validated["fullName"],
                $validated["email"],
                $validated["passwd"]);
        }
        else {
            print("Błędne dane:$errors");
            $this->user = NULL;
        }
        return $this->user;
    }


}
