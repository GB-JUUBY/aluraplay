<?php

namespace Alura\MVC\Helper;

trait HtmlRenderTrait
{
    const CAMINHO_TEMPLATE = __DIR__ . "/../../views/";

    public function RenderizaTemplate(string $template, array $context = []): string
    {
        extract($context);
        ob_start();
        require_once self::CAMINHO_TEMPLATE . "$template.php";
        return ob_get_clean();
    }
}