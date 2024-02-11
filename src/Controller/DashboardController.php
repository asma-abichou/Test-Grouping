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

    public function showDashboard()
    {
        $this->checkIfAuthenticated();
        /*var_dump($_SESSION['user']);
        die();*/

        /*include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/dashboard.html";*/
        include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/tables.phtml";

    }
    public function showSideBar()
    {
        $this->checkIfAuthenticated();
        /*include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/dashboard.html";*/
        include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/layout/sidebar.phtml";

    }

}