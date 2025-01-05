<?php

namespace Alura\MVC\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class Erro404Controller implements RequestHandlerInterface
{
    public function __construct(private Engine $templates)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(404, body: $this->templates->render('erro-404'));
    }
}