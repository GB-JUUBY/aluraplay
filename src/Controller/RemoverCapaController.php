<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;
use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;

class RemoverCapaController implements Controller
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === false || $id === null){
            $this->adicionarMensagem("ID do vídeo inválido", true);
            header("Location: /");
            exit();
        }

        $video = $this->videoRepository->busca($id);
        $capa = $video->getCaminhoImagem();
        $video->setCaminhoImagem(null);

        if ($this->videoRepository->atualizar($video)) {
            EnvioImagemHelper::apagarImagem($capa);
            $this->adicionarMensagem("Capa removida com sucesso!");
            header("Location: /");
        } else {
            $this->adicionarMensagem("Não foi possível remover a capa", true);
            header("Location: /");
            exit();
        }
    }
}