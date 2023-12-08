<?php

class Database {
    private mysqli $mysqli;

    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);

        if ($this->mysqli->connect_errno) {
            printf("Nie udało sie połączenie z serwerem: %s\n", $this->mysqli->connect_error);
            exit();
        }

        if (!$this->mysqli->set_charset("utf8")) {
            print "Nie udało się ustawić utf8";
            exit();
        }
    }

    function __destruct() {
        $this->mysqli->close();
    }

    public function select($sql, $columns) {
        $content = "";
        if ($result = $this->mysqli->query($sql)) {
            $col_count = count($columns);
            $content .= "<table><tbody>";
            while ($row = $result->fetch_object()) {
                $content .= "<tr>";
                for ($i = 0; $i < $col_count; $i++) {
                    $col = $columns[$i];
                    $content .= "<td>" . $row->$col . "</td>";
                }
                $content .= "</tr>";
            }
            $content .= "</table></tbody>";
            $result->close();
        }
        return $content;
    }

    public function delete($sql) {
        return $this->mysqli->query($sql);
    }

    public function insert($sql) {
        return $this->mysqli->query($sql);
    }

    public function getMysqli() {
        return $this->mysqli;
    }
}