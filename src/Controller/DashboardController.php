<?php

namespace App\Controller;

class DashboardController
{
    public function showDashboard()
    {
        include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/dashboard.html";

    }
}