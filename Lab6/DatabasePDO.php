<?php

class DatabasePDO {
    private $dbh;

    public function __construct($serwer, $user, $pass) {
        try {
            $this->dbh = new PDO($serwer, $user, $pass,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function __destruct() {
        $this->dbh = null;
    }

    public function select($sql) {
        return $this->dbh->query($sql);
    }

    public function insert($sql) {
        return $this->dbh->query($sql);
    }

    public function getDbHandle() {
        return $this->dbh;
    }

}