<?php

namespace Andre\Mvc\Helper;

trait HtmlRendererTrait
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    private function rederTemplete(string $templeteName, array $context = []): string
    {
        // extrai o as informações do array
        $templatePath = __DIR__ . '/../../views/';
        extract($context);

        // inicializa um buffer de saida
        ob_start();

        require_once $templatePath . $templeteName . '.php';

        // pega o conteudo do buffer e limpa depois
        return ob_get_clean();

    }
}