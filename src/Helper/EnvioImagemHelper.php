<?php

namespace Alura\MVC\Helper;

use Psr\Http\Message\UploadedFileInterface;

class EnvioImagemHelper
{
    /**
     * Espera um array $_FILES
     * @param UploadedFileInterface|null $arquivo
     * @return bool|string|null
     */
    public static function enviarImagem(?UploadedFileInterface $arquivo): string|null {
        $diretorioUpload = __DIR__ . "/../../public/img/uploads/";

        if ($arquivo->getError() === UPLOAD_ERR_OK) {
            $nomeImagem = $arquivo->getClientFilename();
            $nomeTemporario = $arquivo->getStream()->getMetadata('uri');
            $nomeImagemTratado = basename($nomeImagem);

            $slug = strtolower($nomeImagemTratado);
            $slug = preg_replace('/[^a-z0-9\s\-.]/', '', $slug);
            $slug = str_replace(' ', '-', $slug);
            $slug = trim($slug, '-');

            $nomeImagemSeguro = uniqid('upload_') . '_' . $slug;

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($nomeTemporario);

            if (str_starts_with($mimeType, 'image/')) {
                $arquivo->moveTo($diretorioUpload . $nomeImagemSeguro);

                return $nomeImagemSeguro;
            }
        }

        return null;
    }

    public static function apagarImagem(string $imagem): bool
    {
        return unlink(__DIR__ . "/../../public/img/uploads/" . $imagem);
    }
}
