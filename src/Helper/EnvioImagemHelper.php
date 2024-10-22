<?php

namespace Alura\MVC\Helper;

class EnvioImagemHelper
{
    /**
     * Espera um array $_FILES
     * @param  array|null $arquivo
     * @return bool|string
     */
    public static function enviarImagem(?array $arquivo): bool|string {
        $diretorioUpload = __DIR__ . "/../../public/img/uploads";

        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $nomeImagem = $arquivo['name'];

        $sucesso = move_uploaded_file($arquivo['tmp_name'], $diretorioUpload . $nomeImagem);

        if ($sucesso) {
            return $nomeImagem;
        } else {
            return false;
        }
    }
}