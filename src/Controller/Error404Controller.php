<?php

namespace Andre\Mvc\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;

class Error404Controller implements Controller
{
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        return new Response(404, [], 'Página não encontrada');
    }
}