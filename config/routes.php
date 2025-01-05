<?php

return [
    "GET|/" => Alura\MVC\Controller\ListarVideoController::class,
    "GET|/novo-video" => Alura\MVC\Controller\FormsVideoController::class,
    "POST|/novo-video" => Alura\MVC\Controller\NovoVideoController::class,
    "GET|/editar-video" => Alura\MVC\Controller\FormsVideoController::class,
    "POST|/editar-video" => Alura\MVC\Controller\EditarVideoController::class,
    "GET|/remover-video" => Alura\MVC\Controller\RemoverVideoController::class,
    "GET|/remover-capa" => Alura\MVC\Controller\RemoverCapaController::class,
    "GET|/video-json" => Alura\MVC\Controller\ListarVideosJsonController::class,
    "POST|/video-json" => Alura\MVC\Controller\NovoVideoJsonController::class,
    "GET|/login" => Alura\MVC\Controller\FormularioLoginController::class,
    "POST|/login" => Alura\MVC\Controller\LoginController::class,
    "GET|/logout" => Alura\MVC\Controller\LogoutController::class
];
