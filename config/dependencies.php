<?php

use DI\ContainerBuilder;
use League\Plates\Engine;

$builder = new ContainerBuilder();

$builder->addDefinitions([
   PDO::class => function () {
    $dbPath = __DIR__ . "/../aluraplay.sqlite";

    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
   },
   Engine::class => function () {
    return new Engine(__DIR__ . "/../views");
   }
]);

$container = $builder->build();

return $container;