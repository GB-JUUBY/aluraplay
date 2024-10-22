<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Repository\VideoRepository;

class EditarVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header("Location: /?sucesso=0");
            exit();
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            header("Location: /?sucesso=0");
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false || $titulo === null) {
            header("Location: /?sucesso=0");
            exit();
        }

        $video = new Video(
            $url,
            $titulo
        );
        $video->setId($id);

        if ($this->videoRepository->atualizar($video) === false) {
            header("Location: /?sucesso=0");
            exit();
        }

        header("Location: /?sucesso=1");
    }
}