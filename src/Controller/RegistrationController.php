<?php

namespace App\Controller;

class RegistrationController
{
    public function showRegistrationPage($params)
    {
        /*var_dump($params);*/
         include_once $_SERVER["DOCUMENT_ROOT"] . "/templates/security/sign-up.phtml";
    }

    public function processRegistration($params)
    {
        /*var_dump($params);*/
/*        echo "i am process registration";*/

        header("Location: /dashboard");
        die();
    }
}