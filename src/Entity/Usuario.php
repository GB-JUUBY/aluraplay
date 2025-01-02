<?php

namespace Alura\MVC\Entity;

use InvalidArgumentException;

class Usuario
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $senha;

    public function __construct(
        string $email
    )
    {
        $this->setEmail($email);
    }

    private function setEmail($email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            throw new InvalidArgumentException("e-Mail inválido");
        }
    }

    /**
     * @param string $senha
     */
    public function setSenha(string $senha): void
    {
        if (str_starts_with($senha, '$argon2id$')) {
            $this->senha = $senha;
        } else {
            throw new InvalidArgumentException("Senha deve estar criptografada com o algoritmo Argon2id");
        }
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}