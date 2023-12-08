<?php

class User {
    const STATUS_ADMIN = 0;
    const STATUS_USER = 1;

    private string $userName;
    private string $passwd;
    private string $fullName;
    private string $email;
    private DateTime $date;
    private int $status;

    public function __construct($userName, $fullName, $email, $passwd) {
        $this->userName = $userName;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->passwd = password_hash($passwd, PASSWORD_DEFAULT);
        $this->status = self::STATUS_USER;
        $this->date = new DateTime();
    }

    public function toArray() {
        return [
            "userName" => $this->userName,
            "fullName" => $this->fullName,
            "email" => $this->email,
            "passwd" => $this->passwd,
            "status" => $this->status,
            "date" => $this->date->format("Y-m-d H:i:s")
        ];
    }

    public static function getAllUsers($file) {
        $arr = json_decode(file_get_contents($file));
        foreach ($arr as $val) {
            echo "<p>"
                . $val->userName . " "
                . $val->fullName . " "
                . $val->email . " "
                . $val->passwd . " "
                . $val->status . " "
                . $val->date . "</p>";
        }
    }

    public function save($file) {
        $arr = json_decode(file_get_contents($file), true);
        array_push($arr, $this->toArray());
        file_put_contents($file, json_encode($arr));
    }

    public static function getAllUsersFromXML($file) {
        $allUsers = simplexml_load_file($file);
        echo "<ul>";
        foreach ($allUsers as $user) {
            print "<p>"
                . $user->userName . " "
                . $user->fullName . " "
                . $user->email . " "
                . $user->passwd . " "
                . $user->status . " "
                . $user->date . "</p>";
        }
        echo "</ul>";
    }

    public function saveDB($db) {
        $sql = "INSERT INTO users VALUES(";
        $sql .= "DEFAULT, ";
        $sql .= "'" . "$this->userName" ."', ";
        $sql .= "'" . "$this->fullName" ."', ";
        $sql .= "'" . "$this->email" ."', ";
        $sql .= "'" . "$this->passwd" ."', ";
        $sql .= "'" . "$this->status" ."', ";
        $sql .= "'" . $this->date->format("Y-m-d H:i:s") ."'";
        $sql .= ");";

        if (!$db->insert($sql))
            print("Dodawanie do bazy danych nie powiodło się: <br>" . $db->getMysqli()->error . "<br>");

    }

    public static function getAllUsersFromDB($db) {
        $sql = "SELECT * FROM users";
        $res = $db->select($sql, ["userName", "fullName", "email", "passwd", "status", "date"]);
        if ($res)
            print($res);
        else
            print("Wyszukiwnaie nie powiodło się: <br>" . $db->getMysqli()->error . "<br>");

    }

    public function saveXML($file) {
        $xml = simplexml_load_file($file);
        $xmlCopy = $xml->addChild("user");

        $xmlCopy->addChild("userName", $this->userName);
        $xmlCopy->addChild("fullName", $this->fullName);
        $xmlCopy->addChild("email", $this->email);
        $xmlCopy->addChild("passwd", $this->passwd);
        $xmlCopy->addChild("status", $this->status);
        $xmlCopy->addChild("date", $this->date->format("Y-m-d H:i:s"));

        $xml->asXML('users.xml');
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function setPasswd(string $passwd) {
        $this->passwd = $passwd;
    }

    public function getPasswd(): string {
        return $this->passwd;
    }

    public function setFullName(string $fullName) {
        $this->fullName = $fullName;
    }

    public function getFullName(): string {
        return $this->fullName;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setDate(DateTime $date) {
        $this->date = $date;
    }

    public function getDate(): string {
        return $this->date->format("Y-m-d H:i:s");
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function setStatus(int $status) {
        $this->status = $status;
    }

    public function show() {
        print("$this->userName, $this->fullName, $this->email, $this->passwd, $this->status, " . $this->getDate() . "<br>");
    }


}