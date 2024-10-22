<?php

use Alura\MVC\Controller\Erro404Controller;

require_once __DIR__ . '/../vendor/autoload.php';

$caminhoDB = __DIR__ . "/../aluraplay.sqlite";

$pdo = new PDO("sqlite:$caminhoDB");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pathInfo = $_SERVER['PATH_INFO'] ?? "/";
$requestMethod = $_SERVER['REQUEST_METHOD'];

$eRotaLogin = $pathInfo === "/login";
session_start();
if (!array_key_exists("logado", $_SESSION) && !$eRotaLogin) {
    header("location: /login");
    return;
}

$key = "$requestMethod|$pathInfo";
$routes = require_once __DIR__ . "/../config/routes.php";

if (array_key_exists($key, $routes)) {
    $controllerClass = $routes[$key]["controller"];

    if (array_key_exists('repository', $routes[$key])) {
        $repositoryClass = $routes[$key]["repository"];
        $repository = new $repositoryClass($pdo);
    }

    $controller = new $controllerClass($repository ?? null);
} else {
    $controller = new Erro404Controller();
}

$controller->processaRequisicao();