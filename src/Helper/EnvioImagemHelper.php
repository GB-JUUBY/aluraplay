<?php

namespace Alura\MVC\Helper;

use Exception;

class EnvioImagemHelper
{
    /**
     * Espera um array $_FILES
     * @param array|null $arquivo
     * @return bool|string|null
     */
    public static function enviarImagem(?array $arquivo): bool|string|null {
        $diretorioUpload = __DIR__ . "/../../public/img/uploads/";

        if ($arquivo['error'] === UPLOAD_ERR_OK) {
            $nomeImagem = $arquivo['name'];

            $sucesso = move_uploaded_file($arquivo['tmp_name'], $diretorioUpload . $nomeImagem);

            if ($sucesso) {
                return $nomeImagem;
            } else {
                return false;
            }
        }

        return null;
    }

    public static function apagarImagem(string $imagem): bool
    {
        return unlink(__DIR__ . "/../../public/img/uploads/" . $imagem);
    }
}