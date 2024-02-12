<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\HtmlRendererTrait;

class LoginFormController  implements Controller
{
    use HtmlRendererTrait;
    public function processaRequisicao(): void
    {
        // Se já estiver logado
        if(array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header('Location: /');
            return;
        }

        echo $this->rederTemplete('login-form');
    }
}