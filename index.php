<?php
require_once __DIR__ . "/vendor/autoload.php";

use App\Router;
use App\Controller\LoginController;

$router = new Router();


$router->get('/login', LoginController::class . '::test');

$router->addNotFoundHandler(function () {
    echo "This page does not exist! Please contact Abla Lahdhoubi";
});
$router->run();