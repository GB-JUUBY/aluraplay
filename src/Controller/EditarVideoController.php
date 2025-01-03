<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Helper\{EnvioImagemHelper, FlashMessageTrait};
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

class EditarVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $body= $request->getParsedBody();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            $this->adicionarMensagem("ID do vídeo inválido", true);
            return new Response(
                302,
                [
                    'Location' => '/editar-video'
                ]
            );
        }

        $url = filter_var($body['url'], FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            $this->adicionarMensagem("URL do vídeo inválida", true);
            return new Response(
                302,
                [
                    'Location' => '/editar-video'
                ]
            );
        }

        $titulo = filter_var($body['titulo']);
        if ($titulo === false || $titulo === null) {
            $this->adicionarMensagem("Título do vídeo inválido", true);
            return new Response(
                302,
                [
                    'Location' => '/editar-video'
                ]
            );
        }

        $imagemAtual = $this->videoRepository->busca($id)->getCaminhoImagem();

        $video = new Video(
            $url,
            $titulo
        );
        $video->setId($id);
        $video->setCaminhoImagem($imagemAtual);

        $files = $request->getUploadedFiles();
        $imagem = EnvioImagemHelper::enviarImagem($files['image']);
        $video->setCaminhoImagem($imagem);

        if ($imagem !== null) {
            $video->setCaminhoImagem($imagem);
            if ($imagemAtual !== null) {
                EnvioImagemHelper::apagarImagem($imagemAtual);
            }
        }

        if ($this->videoRepository->atualizar($video) === false) {
            $this->adicionarMensagem("Falha ao atualizar o vídeo", true);
            return new Response(
                302,
                [
                    'Location' => "/editar-video?id=$id"
                ]
            );
        }

        $this->adicionarMensagem("Vídeo atualizado com sucesso");
        return new Response(
            200,
            [
                'Location' => "/"
            ]
        );
    }
}