<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Repository\VideoRepository;

class FormsVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        $action = "/novo-video";
        if ($id !== false && $id !== null) {
            $video = $this->videoRepository->busca($id);
            $action = "/editar-video?id=$video->id";
        }

        require_once __DIR__ . "/../../views/formulario.php";
    }
}