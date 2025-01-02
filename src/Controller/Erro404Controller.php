<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;

class Erro404Controller implements Controller
{
    use HtmlRenderTrait;

    public function __construct()
    {
    }

    public function processaRequisicao(): void
    {
        echo $this->RenderizaTemplate('erro-404');
        http_response_code(404);
    }
}