<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class FormsVideoController implements RequestHandlerInterface
{
    use HtmlRenderTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parametros = $request->getQueryParams();
        $id = filter_var($parametros["id"], FILTER_VALIDATE_INT);
        $action = "/novo-video";
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->busca($id);
            $action = "/editar-video?id=$video->id";

            $context["video"] = $video;
        }

        $context["action"] = $action;

        return new Response(
            200,
            body: $this->RenderizaTemplate(
                "formulario",
                $context
            )
        );
    }
}