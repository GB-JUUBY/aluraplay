<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;
use Alura\MVC\Repository\VideoRepository;

class Erro404Controller extends TemplateController
{
    public function __construct()
    {
    }

    public function processaRequisicao(): void
    {
        echo $this->RenderizaTemplate('erro-404');
        http_response_code(404);
    }
}