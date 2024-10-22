<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;
use Alura\MVC\Repository\VideoRepository;

class Erro404Controller implements Controller
{
    public function __construct()
    {
    }

    public function processaRequisicao(): void
    {
        require_once __DIR__ . "/../../views/erro-404.php";
        http_response_code(404);
    }
}