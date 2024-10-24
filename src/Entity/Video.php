<?php

namespace Alura\MVC\Entity;

use InvalidArgumentException;
class Video
{
    public readonly string $url;
    public readonly int $id;
    private ?string $caminhoImagem;
    public function __construct(
        string $url,
        public readonly string $titulo
    )
    {
        $this->setUrl($url);
    }

    private function setUrl($url): void
    {
        if ($url = filter_var($url, FILTER_VALIDATE_URL)) {
            $this->url = $url;
        } else {
            throw new InvalidArgumentException("URL inválida.");
        }
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setCaminhoImagem(?string $caminhoImagem): void
    {
        $this->caminhoImagem = $caminhoImagem;
    }

    public function getCaminhoImagem(): ?string
    {
        return $this->caminhoImagem;
    }
}