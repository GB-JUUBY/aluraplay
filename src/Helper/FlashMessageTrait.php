<?php

namespace Alura\MVC\Helper;

trait FlashMessageTrait
{
    private function adicionarMensagem(string $mensagem, bool $erro = false): void {
        $_SESSION['mensagem'] = $mensagem;
        $_SESSION['erro'] = $erro;
    }
}