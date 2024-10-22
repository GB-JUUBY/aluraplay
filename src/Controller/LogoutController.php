<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;

class LogoutController implements Controller
{

    public function processaRequisicao(): void
    {
        unset($_SESSION['logado']);
        header("location: /");
    }
}