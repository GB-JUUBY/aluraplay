<?php

namespace Alura\MVC\Repository;

use Alura\MVC\Entity\Video;
use PDO;
class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function adicionar(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, titulo, caminho_imagem) VALUES (:url, :titulo, :caminho_imagem)";
        $statement = $this->pdo->prepare($sql);

        $url = $video->url;
        $titulo = $video->titulo;
        $caminhoImagem = $video->getCaminhoImagem();

        $statement->bindParam(":url", $url);
        $statement->bindParam(":titulo", $titulo);
        $statement->bindParam(":caminho_imagem", $caminhoImagem);

        return $statement->execute();
    }

    public function remover(Video $video): bool
    {
        $sql = "DELETE FROM videos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);

        $id = $video->id;

        $statement->bindParam(":id", $id, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function atualizar(Video $video): bool
    {
        $atualizaImagemSql = "";
        if ($video->getCaminhoImagem() !== null) {
            $atualizaImagemSql = ", caminho_imagem = :caminho_imagem";
            $caminhoImagem = $video->getCaminhoImagem();
        }

        $sql = "UPDATE videos SET url = :url, 
                                  titulo = :titulo
                                  $atualizaImagemSql
                WHERE id = :id";
        $statement = $this->pdo->prepare($sql);

        $url = $video->url;
        $titulo = $video->titulo;
        $id = $video->id;

        $statement->bindParam(":url", $url);
        $statement->bindParam(":titulo", $titulo);
        $statement->bindParam(":id", $id);
        if ($video->getCaminhoImagem() !== null) {
            $statement->bindParam(":caminho_imagem", $caminhoImagem);
        }

        return $statement->execute();
    }

    /**
     * @return Video[]
     */
    public function listar(): array
    {
        $sql = "SELECT * FROM videos";
        $statement = $this->pdo->query($sql);
        $dadosVideos = $statement->fetchAll();

        return array_map(function ($dadosVideo) {
            $video = new Video(
                $dadosVideo['url'],
                $dadosVideo['titulo']
            );
            $video->setId($dadosVideo['id']);
            $video->setCaminhoImagem($dadosVideo['caminho_imagem']);

            return $video;
        }, $dadosVideos);
    }

    public function busca(int $id): Video
    {
        $sql = "SELECT * FROM videos WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        $dadosVideo = $statement->fetch();

        $video = new Video(
            $dadosVideo['url'],
            $dadosVideo['titulo']
        );
        $video->setId($dadosVideo['id']);
        $video->setCaminhoImagem($dadosVideo['caminho_imagem']);

        return $video;
    }
}