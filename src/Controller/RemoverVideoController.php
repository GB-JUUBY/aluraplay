<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;

class RemoverVideoController implements Controller
{
    use FlashMessageTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
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

        if (!is_null($video->getCaminhoImagem())) {
            EnvioImagemHelper::apagarImagem($video->getCaminhoImagem());
        }

        if ($this->videoRepository->remover($video) === false) {
            $this->adicionarMensagem("Não foi possível excluir o vídeo", true);
            header("Location: /");
            exit();
        }

        $this->adicionarMensagem("Vídeo removido com sucesso!");
        header("Location: /");
    }
}