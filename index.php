<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Router;
use App\Controller\LoginController;
use App\Controller\RegistrationController;
use App\Controller\DashboardController;

$router = new Router();


//Login Route
$router->get('/login', LoginController::class . '::test');

// Registration Route
$router->get('/register', RegistrationController::class . '::showRegistrationPage');
$router->post('/register', RegistrationController::class . '::processRegistration');

$router->get('/dashboard', DashboardController::class . '::showDashboard');




$router->addNotFoundHandler(function () {
    echo "This page does not exist! Please contact Abla Lahdhoubi";
});
$router->run();