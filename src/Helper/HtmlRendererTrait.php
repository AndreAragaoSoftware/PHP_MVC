<?php

namespace Andre\Mvc\Helper;

trait HtmlRendererTrait
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    private function rederTemplete(string $templeName, array $context = []): string
    {
        // extrai o as informações do array
        extract($context);

        // inicializa um buffer de saida
        ob_start();

        require_once self::TEMPLATE_PATH . $templeName . '.php';

        // pega o conteudo do buffer e limpa depois
        return ob_get_clean();

    }
}