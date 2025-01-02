<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;

class FormularioLoginController implements Controller
{
    use HtmlRenderTrait;

    public function processaRequisicao(): void
    {
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header('location: /');
        }
        echo $this->RenderizaTemplate('formulario-login');
    }
}