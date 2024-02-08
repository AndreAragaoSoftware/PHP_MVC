<?php

namespace Andre\Mvc\Controller;

class LoginFormController implements Controller
{
    public function processaRequisicao(): void
    {
        // Se já estiver logado
        if($_SESSION['logado'] === true) {
            header('Location: /');
            return;
        }

        require_once __DIR__ . '/../../views/login-form.php';
    }
}