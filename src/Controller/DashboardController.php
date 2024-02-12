<?php

namespace App\Controller;

class DashboardController
{
    public function checkIfAuthenticated()
    {
        if(!isset($_SESSION['user'])){
            header("Location: /login");
            die();
        }
    }
}