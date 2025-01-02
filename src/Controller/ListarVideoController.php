<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Repository\VideoRepository;

class ListarVideoController extends TemplateController
{
    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $listaVideos = $this->videoRepository->listar();
        echo $this->RenderizaTemplate(
            'listar-videos',
            [
                'listaVideos' => $listaVideos
            ]
        );
    }
}