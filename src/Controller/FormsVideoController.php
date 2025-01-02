<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;
use Alura\MVC\Repository\VideoRepository;

readonly class FormsVideoController implements Controller
{
    use HtmlRenderTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $action = "/novo-video";
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->busca($id);
            $action = "/editar-video?id=$video->id";

            $context["video"] = $video;
        }

        $context["action"] = $action;

        echo $this->RenderizaTemplate(
            "formulario",
            $context
        );
    }
}