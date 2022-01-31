<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\Service\Router;
use App\Service\Http\Request;

$request = new Request($_GET, $_POST, $_SERVER);
$router = new Router($request);
$response = $router->run();
$response->send();
