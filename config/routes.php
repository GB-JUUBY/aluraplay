<?php

return [
    "GET|/" => [
        "controller" => \Alura\MVC\Controller\ListarVideoController::class,
        "repository" => \Alura\MVC\Repository\VideoRepository::class
    ],
    "GET|/novo-video" => [
        "controller" => \Alura\MVC\Controller\FormsVideoController::class,
        "repository" => \Alura\MVC\Repository\VideoRepository::class
    ],
    "POST|/novo-video" => [
        "controller" => \Alura\MVC\Controller\NovoVideoController::class,
        "repository" => \Alura\MVC\Repository\VideoRepository::class
    ],
    "GET|/editar-video" => [
        "controller" => \Alura\MVC\Controller\FormsVideoController::class,
        "repository" => \Alura\MVC\Repository\VideoRepository::class
    ],
    "POST|/editar-video" => [
        "controller" => \Alura\MVC\Controller\EditarVideoController::class,
        "repository" => \Alura\MVC\Repository\VideoRepository::class
    ],
    "GET|/remover-video" => [
        "controller" => \Alura\MVC\Controller\RemoverVideoController::class,
        "repository" => \Alura\MVC\Repository\VideoRepository::class
    ],
    "GET|/login" => [
        "controller" => \Alura\MVC\Controller\FormularioLoginController::class,
        "repository" => \Alura\MVC\Repository\UsuarioRepository::class
    ],
    "POST|/login" => [
        "controller" => \Alura\MVC\Controller\LoginController::class,
        "repository" => \Alura\MVC\Repository\UsuarioRepository::class
    ],
    "GET|/logout" => [
        "controller" => \Alura\MVC\Controller\LogoutController::class
    ]
];
