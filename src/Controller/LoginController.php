<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\UserRepository;

class LoginController implements Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        // Chama o método userFind para verificar o login
        $this->userRepository->userFind($email, $password);
    }
}
