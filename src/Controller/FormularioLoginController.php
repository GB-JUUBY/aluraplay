<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;

class FormularioLoginController implements Controller
{

    public function processaRequisicao(): void
    {
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header('location: /');
        }
        require_once __DIR__ . '/../../views/formulario-login.php';
    }
}