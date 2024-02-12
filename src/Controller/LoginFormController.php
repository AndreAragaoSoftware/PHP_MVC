<?php

namespace Andre\Mvc\Controller;

class LoginFormController extends ControllerWithHtml implements Controller
{
    public function processaRequisicao(): void
    {
        // Se já estiver logado
        if(array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            header('Location: /');
            return;
        }

        $this->rederTemplete('login-form');
    }
}