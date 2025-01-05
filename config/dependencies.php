<?php

use Psr\Container\ContainerInterface;

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions([
   PDO::class => function () {
    $dbPath = __DIR__ . "/../aluraplay.sqlite";

    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
   }
]);

$container = $builder->build();

return $container;