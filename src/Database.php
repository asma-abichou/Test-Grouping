<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    public static function getDbConnection()
    {
        $servername = "localhost";
        $username = "asma";
        $password = "asma";
        $dbname = "test-grouping";
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            //set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;

        } catch (PDOException $e) {
            echo "Connection is failed:" . $e->getMessage();
        }
    }

}