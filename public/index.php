<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

use App\Service\Router;
use App\Service\Http\Request;

// TODO => créer un fichier .env pour mettre la configuration dedans.

//$data = new Database();
//$data->getPDO();
$request = new Request($_GET, $_POST, $_SERVER);
$router = new Router($request);
$response = $router->run();
$response->send();
