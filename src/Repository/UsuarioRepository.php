<?php

namespace Alura\MVC\Repository;

use Alura\MVC\Entity\Usuario;
use PDO;
class UsuarioRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function adicionar(Usuario $usuario): bool
    {
        $sql = "INSERT INTO usuarios (email, senha) VALUES (:email, :senha)";
        $statement = $this->pdo->prepare($sql);

        $email = $usuario->email;
        $senha = $usuario->senha;

        $statement->bindParam(":email", $email);
        $statement->bindParam(":senha", $senha);

        return $statement->execute();
    }

    public function remover(Usuario $usuario): bool
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $statement = $this->pdo->prepare($sql);

        $id = $usuario->id;

        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function atualizar(Usuario $usuario): bool
    {
        $sql = "UPDATE usuarios SET email = :email, senha = :senha WHERE id = :id";
        $statement = $this->pdo->prepare($sql);

        $email = $usuario->email;
        $senha = $usuario->senha;
        $id = $usuario->id;

        $statement->bindParam(":email", $email);
        $statement->bindParam(":senha", $senha);
        $statement->bindParam(":id", $id);

        return $statement->execute();
    }

    /**
     * @return Usuario[]
     */
    public function listar(): array
    {
        $sql = "SELECT * FROM usuarios";
        $statement = $this->pdo->query($sql);
        $dadosUsuarios = $statement->fetchAll();

        return array_map(function ($dadosUsuario) {
            $usuario = new Usuario(
                $dadosUsuario['email'],
                $dadosUsuario['senha']
            );
            $usuario->setId($dadosUsuario['id']);

            return $usuario;
        }, $dadosUsuarios);
    }

    public function busca(string $email): Usuario
    {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":email", $email, PDO::PARAM_STR);
        $statement->execute();
        $dadosUsuario = $statement->fetch();

        $usuario = new Usuario(
            $dadosUsuario['email'],
            $dadosUsuario['senha']
        );
        $usuario->setId($dadosUsuario['id']);

        return $usuario;
    }
}