<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;

class NovoVideoController implements Controller
{
    use FlashMessageTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            $this->adicionarMensagem("URL do vídeo inválida", true);
            header("Location: /novo-video");
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false || $titulo === null) {
            $this->adicionarMensagem("Título do vídeo inválida", true);
            header("Location: /novo-video");
            exit();
        }

        $video = new Video(
            $url,
            $titulo
        );

        $imagem = EnvioImagemHelper::enviarImagem($_FILES['image']);

        if ($imagem !== false) {
                $video->setCaminhoImagem($imagem);
        } else {
            $this->adicionarMensagem("Não foi possível enviar a imagem de capa", true);
            header("Location: /novo-video");
            exit();
        }


        if ($this->videoRepository->adicionar($video) === false) {
            $this->adicionarMensagem("Não foi possível enviar o vídeo", true);
            header("Location: /novo-video");
            exit();
        }

        $this->adicionarMensagem("Vídeo enviado com sucesso!");
        header("Location: /");
    }
}