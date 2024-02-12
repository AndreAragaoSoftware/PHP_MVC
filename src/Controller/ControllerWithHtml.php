<?php

namespace Andre\Mvc\Controller;

abstract class ControllerWithHtml implements Controller
{
    private const TEMPLATE_PATH = __DIR__ . '/../../views/';
    protected function rederTemplete(string $templeName, array $context = []): void
    {
        // extrai o as informações do array
        extract($context);

        require_once self::TEMPLATE_PATH . $templeName . '.php';
    }
}