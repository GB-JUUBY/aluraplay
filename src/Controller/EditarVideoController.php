<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;

class EditarVideoController implements Controller
{
    use FlashMessageTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->adicionarMensagem("ID do vídeo inválido", true);
            header("Location: /editar-video");
            exit();
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            $this->adicionarMensagem("URL do vídeo inválida", true);
            header("Location: /editar-video");
            exit();
        }

        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false || $titulo === null) {
            $this->adicionarMensagem("Título do vídeo inválido", true);
            header("Location: /editar-video");
            exit();
        }

        $imagemAtual = $this->videoRepository->busca($id)->getCaminhoImagem();

        $video = new Video(
            $url,
            $titulo
        );
        $video->setId($id);
        $video->setCaminhoImagem($imagemAtual);

        $imagem = EnvioImagemHelper::enviarImagem($_FILES['image']);

        if ($imagem !== false && $imagem !== null) {
            $video->setCaminhoImagem($imagem);
            if ($imagemAtual !== null) {
                EnvioImagemHelper::apagarImagem($imagemAtual);
            }
        }

        if ($this->videoRepository->atualizar($video) === false) {
            $this->adicionarMensagem("Falha ao atualizar o vídeo", true);
            header("Location: /editar-video?id=$id");
            exit();
        }

        $this->adicionarMensagem("Vídeo atualizado com sucesso");
        header("Location: /");
    }
}