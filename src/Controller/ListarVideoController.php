<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class ListarVideoController implements RequestHandlerInterface
{
    public function __construct(
        private VideoRepository $videoRepository,
        private Engine          $templates
    )
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $listaVideos = $this->videoRepository->listar();
        $context['listaVideos'] = $listaVideos;

        return new Response(
            200,
            body: $this->templates->render('listar-videos', $context)
        );
    }
}