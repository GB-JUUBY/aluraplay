<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Entity\Video;
use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class NovoVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parametros = $request->getParsedBody();
        
        $url = filter_var($parametros['url'], FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            $this->adicionarMensagem("URL do vídeo inválida", true);
            return new Response(
                302,
                [
                    'Location' => '/novo-video'
                ]
            );
        }

        $titulo = filter_var($parametros['titulo']);
        if ($titulo === false || $titulo === null) {
            $this->adicionarMensagem("Título do vídeo inválida", true);
            return new Response(
                302,
                [
                    'Location' => '/novo-video'
                ]
            );
        }

        $video = new Video(
            $url,
            $titulo
        );

        $files = $request->getUploadedFiles();
        $imagem = EnvioImagemHelper::enviarImagem($files['image']);
        $video->setCaminhoImagem($imagem);

        if ($this->videoRepository->adicionar($video) === false) {
            $this->adicionarMensagem("Não foi possível enviar o vídeo", true);
            return new Response(
                302,
                [
                    'Location' => '/novo-video'
                ]
            );
        }

        $this->adicionarMensagem("Vídeo enviado com sucesso!");
        return new Response(
            200,
            [
                'Location' => '/'
            ]
        );
    }
}