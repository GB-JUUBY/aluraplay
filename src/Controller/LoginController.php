<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Controller\Controller;
use Alura\MVC\Repository\UsuarioRepository;

class LoginController implements Controller
{
    public function __construct(private UsuarioRepository $usuarioRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        if ($email === false || $email === null) {
            header("Location: /login?sucesso=0");
        }
        $senha = filter_input(INPUT_POST, "senha");
        if ($senha === false || $senha === null) {
            header("Location: /login?sucesso=0");
        }
        $usuario = $this->usuarioRepository->busca($email);

        if (password_verify($senha, $usuario->senha)) {
            $_SESSION["logado"] = true;
            header("Location: /");
        } else {
            header("Location: /login?sucesso=0");
        }
    }
}