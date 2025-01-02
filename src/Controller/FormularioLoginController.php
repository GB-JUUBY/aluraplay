<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;

class FormularioLoginController extends TemplateController
{

    public function processaRequisicao(): void
    {
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header('location: /');
        }
        echo $this->RenderizaTemplate('formulario-login');
    }
}