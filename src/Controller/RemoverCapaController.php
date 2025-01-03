<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\EnvioImagemHelper;
use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoverCapaController implements RequestHandlerInterface
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
        $capa = $video->getCaminhoImagem();
        $video->setCaminhoImagem(null);

        if ($this->videoRepository->atualizar($video)) {
            EnvioImagemHelper::apagarImagem($capa);
            $this->adicionarMensagem("Capa removida com sucesso!");
            return new Response(
                200,
                [
                    "Location" => "/"
                ]
            );
        } else {
            $this->adicionarMensagem("Não foi possível remover a capa", true);
            return new Response(
                302,
                [
                    "Location" => "/"
                ]
            );
        }
    }
}