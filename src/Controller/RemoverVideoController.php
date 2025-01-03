<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoverVideoController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private readonly VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parametros = $request->getQueryParams();

        $id = filter_var($parametros["id"], FILTER_VALIDATE_INT);
        if ($id === false || $id === null){
            $this->adicionarMensagem("ID do vídeo inválido", true);
            return new Response(
                302,
                [
                    "Location" => "/"
                ]
            );
        }

        $video = $this->videoRepository->busca($id);

        if (!is_null($video->getCaminhoImagem())) {
            EnvioImagemHelper::apagarImagem($video->getCaminhoImagem());
        }

        if ($this->videoRepository->remover($video) === false) {
            $this->adicionarMensagem("Não foi possível excluir o vídeo", true);
            return new Response(
                302,
                [
                    "Location" => "/"
                ]
            );
        }

        $this->adicionarMensagem("Vídeo removido com sucesso!");
        return new Response(
            200,
            [
                "Location" => "/"
            ]
        );
    }
}