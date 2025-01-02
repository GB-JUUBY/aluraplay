<?php

namespace Alura\MVC\Controller;

use Alura\MVC\Helper\FlashMessageTrait;
use Alura\MVC\Repository\UsuarioRepository;

class LoginController implements Controller
{
    use FlashMessageTrait;

    public function __construct(private readonly UsuarioRepository $usuarioRepository)
    {
    }

    public function processaRequisicao(): void
    {

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        if ($email === false || $email === null) {
            $this->adicionarMensagem("E-mail inválido", true);
            header("Location: /login");
            exit();
        }
        $senha = filter_input(INPUT_POST, "senha");
        if ($senha === false || $senha === null) {
            $this->adicionarMensagem("Senha inválida", true);
            header("Location: /login");
            exit();
        }
        $usuario = $this->usuarioRepository->busca($email);

        if ($usuario === null) {
            $this->adicionarMensagem("E-mail e/ou senha incorretos", true);
            header("Location: /login");
            exit();
        }

        $senhaCorreta = password_verify($senha, $usuario->senha);

        if ($senhaCorreta) {
            if (password_needs_rehash($usuario->senha, PASSWORD_ARGON2ID)) {
                $novoHash = password_hash($senha, PASSWORD_ARGON2ID);
                $usuario->setSenha($novoHash);
                $this->usuarioRepository->atualizar($usuario);
            }
            $_SESSION["logado"] = true;
            header("Location: /");
        } else {
            $this->adicionarMensagem("E-mail e/ou senha incorretos", true);
            header("Location: /login");
            exit();
        }
    }
}