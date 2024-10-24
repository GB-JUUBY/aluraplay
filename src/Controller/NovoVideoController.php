<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Repository\VideoRepository;

class NovoVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            header("Location: /?sucesso=0");
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        if ($titulo === false || $titulo === null) {
            header("Location: /?sucesso=0");
            exit();
        }

        $video = new Video(
            $url,
            $titulo
        );

        $imagem = EnvioImagemHelper::enviarImagem($_FILES['image']);

        if ($imagem !== false) {
                $video->setCaminhoImagem($imagem);
        }


        if ($this->videoRepository->adicionar($video) === false) {
            header("Location: /?sucesso=0");
            exit();
        }

        header("Location: /?sucesso=1");
    }
}