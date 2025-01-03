<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Repository\VideoRepository;
use Alura\MVC\Entity\Video;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class NovoVideoJsonController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parametros = $request->getParsedBody();

        $url = filter_var($parametros['url'], FILTER_VALIDATE_URL);
        if ($url === false || $url === null) {
            return new Response(
                403,
                body: json_encode(
                    [
                        "erro" => true,
                        "mensagem" => "URL inválida"
                    ]
                )
            );
        }

        $titulo = filter_var($parametros['titulo']);
        if ($titulo === false || $titulo === null) {
            return new Response(
                403,
                body: json_encode(
                    [
                        "erro" => true,
                        "mensagem" => "Título inválido"
                    ]
                )
            );
        }

        $video = new Video($url, $titulo);

        if ($this->videoRepository->adicionar($video)){
            return new Response(200);
        } else {
            return new Response(
                403,
                body: json_encode(
                    [
                        "erro" => true,
                        "mensagem" => "Erro ao adicionar video"
                    ]
                )
            );
        }
    }
}