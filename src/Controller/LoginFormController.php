<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\HtmlRendererTrait;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginFormController  implements Controller
{
    use HtmlRendererTrait;
    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        // Se já estiver logado
        if(array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        return new Response(200, body: $this->rederTemplete('login-form')) ;
    }


}