<?php

use Alura\MVC\Controller\Erro404Controller;
use Psr\Http\Server\RequestHandlerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$caminhoDB = __DIR__ . "/../aluraplay.sqlite";

$pdo = new PDO("sqlite:$caminhoDB");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$pathInfo = $_SERVER['PATH_INFO'] ?? "/";
$requestMethod = $_SERVER['REQUEST_METHOD'];

$eRotaLogin = $pathInfo === "/login";

session_set_cookie_params([
    'samesite' => 'lax',
    'httponly' => true
]);

session_start();

if (isset($_SESSION['logado'])) {
    $logado = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $logado;
}

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

$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);

$request = $creator->fromGlobals();

/** @var RequestHandlerInterface $controller */
$response = $controller->handle($request);

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

echo $response->getBody();
