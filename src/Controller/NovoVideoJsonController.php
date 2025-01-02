<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;
use Alura\MVC\Repository\VideoRepository;
use Alura\MVC\Entity\Video;

class NovoVideoJsonController implements Controller
{
    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $request = json_decode(file_get_contents('php://input'));

        $video = new Video($request->url, $request->titulo);
        $video->setCaminhoImagem($request->caminho_imagem);

        if ($this->videoRepository->adicionar($video)){
            http_response_code(201);
        } else {
            http_response_code(403);
        }
    }
}