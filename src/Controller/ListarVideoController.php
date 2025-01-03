<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListarVideoController implements RequestHandlerInterface
{
    use HtmlRenderTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $listaVideos = $this->videoRepository->listar();
        $context['listaVideos'] = $listaVideos;

        return new Response(
            200,
            body: $this->RenderizaTemplate(
                'listar-videos',
                $context
            )
        );
    }
}