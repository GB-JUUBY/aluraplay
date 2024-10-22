<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Repository\VideoRepository;

class ListarVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $listaVideos = $this->videoRepository->listar();
        require_once __DIR__ . "/../../views/listar-videos.php";
    }
}