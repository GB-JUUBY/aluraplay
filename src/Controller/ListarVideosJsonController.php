<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListarVideosJsonController implements RequestHandlerInterface
{
    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dadosVideos = $this->videoRepository->listar();

        $listaVideos = array_map(function (Video $video): array {
            return [
                'url' => $video->url,
                'titulo' => $video->titulo,
                'caminho_imagem' => !is_null($video->getCaminhoImagem()) ? '/img/upload/' . $video->getCaminhoImagem() : $video->getCaminhoImagem()
            ];
        }, $dadosVideos);

        return new Response(
            200,
            [
                'Content-Type' => 'application/json'
            ],
            json_encode($listaVideos)
        );
    }
}