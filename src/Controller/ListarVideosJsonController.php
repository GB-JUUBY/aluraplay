<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;
use Alura\MVC\Entity\Video;
use Alura\MVC\Repository\VideoRepository;

class ListarVideosJsonController implements Controller
{
    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $dadosVideos = $this->videoRepository->listar();

        $listaVideos = array_map(function (Video $video): array {
            return [
                'url' => $video->url,
                'titulo' => $video->titulo,
                'caminho_imagem' => !is_null($video->getCaminhoImagem()) ? '/img/upload/' . $video->getCaminhoImagem() : $video->getCaminhoImagem()
            ];
        }, $dadosVideos);
        header('Content-Type: application/json');
        echo json_encode($listaVideos);
    }
}