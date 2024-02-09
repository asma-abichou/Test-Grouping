<?php

namespace App\Controller;

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
        include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/tables.phtml";
    }

}