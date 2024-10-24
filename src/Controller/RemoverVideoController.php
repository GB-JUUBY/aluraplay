<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Repository\VideoRepository;

class RemoverVideoController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === false || $id === null){
            header("Location: /?sucesso=0");
            exit();
        }

        $video = $this->videoRepository->busca($id);

        if (!is_null($video->getCaminhoImagem())) {
            EnvioImagemHelper::apagarImagem($video->getCaminhoImagem());
        }

        if ($this->videoRepository->remover($video) === false) {
            header("Location: /?sucesso=0");
            exit();
        }

        header("Location: /?sucesso=1");
    }
}