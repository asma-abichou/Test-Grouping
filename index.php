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


// Table Members Route
$router->get('/dashboard/members/list', MemberController::class . '::membersList');
// edit member template route
$router->get('/dashboard/members/edit', MemberController::class . '::editMemberTemplateShow');
// validate member route
$router->get('/dashboard/members/validate', MemberController::class . '::validateMember');

//profile Route
$router->get('/dashboard/my-profile', UserController::class . '::myProfile');


$router->addNotFoundHandler(function () {
    echo "This page does not exist! Please contact Abla Lahdhoubi";
});
$router->run();