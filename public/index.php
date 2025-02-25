<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

use App\Core\Router;

$router = new Router();
$request = $_SERVER['REQUEST_URI'] ?? "/";
$router->route($request);
