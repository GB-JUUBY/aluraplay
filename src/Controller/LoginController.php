<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\UsuarioRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private readonly UsuarioRepository $usuarioRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parametros = $request->getParsedBody();

        $email = filter_var($parametros["email"], FILTER_VALIDATE_EMAIL);
        if ($email === false || $email === null) {
            $this->adicionarMensagem("E-mail inválido", true);
            return new Response(
                302,
                [
                    "Location" => "/login",
                ]
            );
        }

        $senha = filter_var($parametros["senha"]);
        if ($senha === false || $senha === null) {
            $this->adicionarMensagem("Senha inválida", true);
            return new Response(
                302,
                [
                    "Location" => "/login",
                ]
            );
        }

        $usuario = $this->usuarioRepository->busca($email);

        if ($usuario === null) {
            $this->adicionarMensagem("E-mail e/ou senha incorretos", true);
            return new Response(
                302,
                [
                    "Location" => "/login",
                ]
            );
        }

        $senhaCorreta = password_verify($senha, $usuario->senha);

        if (!$senhaCorreta) {
            $this->adicionarMensagem("Usuário ou senha incorretos", true);
            return new Response(302, ['Location' => '/login']);
        }

        if (password_needs_rehash($usuario->senha, PASSWORD_ARGON2ID)) {
            $novoHash = password_hash($senha, PASSWORD_ARGON2ID);
            $usuario->setSenha($novoHash);
            $this->usuarioRepository->atualizar($usuario);
        }

        $_SESSION["logado"] = true;
        return new Response(302, ["Location" => "/"]);
    }
}