<?php

namespace App\Controller;

use App\Database;
use PDO;

class TableController
{
    public function checkIfAuthenticated()
    {
        if(!isset($_SESSION['user'])){
            header("Location: /login");
            die();
        }
    }
    public function showTable(){
        //check if the user is authenticated
        $this->checkIfAuthenticated();
        $db = Database::getDbConnection();
        $query = "SELECT * FROM membre";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $members = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include_once  $_SERVER["DOCUMENT_ROOT"] . '/templates/tables.phtml';
    }

}
