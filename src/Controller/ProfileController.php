<?php

namespace App\Controller;

class ProfileController
{
    public function checkIfAuthenticated()
    {
        if(!isset($_SESSION['user'])){
            header("Location: /login");
            die();
        }
    }
    public function showProfile(){
        //check if the user is authenticated
        $this->checkIfAuthenticated();
        include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/profile.phtml";
    }
}