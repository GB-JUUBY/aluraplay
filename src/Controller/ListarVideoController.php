<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;
use Alura\MVC\Repository\VideoRepository;

class ListarVideoController implements Controller
{
    use HtmlRenderTrait;

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