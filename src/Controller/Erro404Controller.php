<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\HtmlRenderTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Erro404Controller implements RequestHandlerInterface
{
    use HtmlRenderTrait;

    public function __construct()
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(404, body: $this->RenderizaTemplate('erro-404'));
    }
}