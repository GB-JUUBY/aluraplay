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

            $nomeImagemTratado = basename($nomeImagem);

            $slug = strtolower($nomeImagemTratado);
            $slug = preg_replace('/[^a-z0-9\s\-.]/', '', $slug);
            $slug = str_replace(' ', '-', $slug);
            $slug = trim($slug, '-');

            $nomeImagemSeguro = uniqid('upload_') . '_' . $slug;

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($arquivo['tmp_name']);

            if (str_starts_with($mimeType, 'image/')) {
                return move_uploaded_file(
                    $arquivo['tmp_name'],
                    $diretorioUpload . $nomeImagemSeguro
                )
                    ? $nomeImagemSeguro : false;
            }
        }

        return null;
    }

    public static function apagarImagem(string $imagem): bool
    {
        return unlink(__DIR__ . "/../../public/img/uploads/" . $imagem);
    }
}
