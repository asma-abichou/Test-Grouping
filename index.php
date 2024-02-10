<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Controller\UserController;
use App\Controller\MemberController;
use App\Router;
use App\Controller\LoginController;
use App\Controller\RegistrationController;
use App\Controller\DashboardController;

$router = new Router();


// Login Route
$router->get('/login', LoginController::class . '::showLoginPage');
$router->post('/login', LoginController::class . '::processLogin');
// Registration Route
$router->get('/register', RegistrationController::class . '::showRegistrationPage');
$router->post('/register', RegistrationController::class . '::processRegistration');



// Logout Route
$router->get('/logout', LoginController::class . '::logout');

// Dashboard Route
$router->get('/dashboard', DashboardController::class . '::showDashboard');

// Table Members Route
$router->get('/table', MemberController::class . '::showTable');
$router->get('/table/editMember', MemberController::class . '::showMember');
$router->post('/table/editMember', MemberController::class . '::editMember');

//profile Route
$router->get('/profile', UserController::class . '::getProfileData');


$router->addNotFoundHandler(function () {
    echo "This page does not exist! Please contact Abla Lahdhoubi";
});
$router->run();