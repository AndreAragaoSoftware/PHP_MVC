<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\UserRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController implements Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getParsedBody();
        $email = filter_var($queryParams['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($queryParams['password']);


        try {
            // Chama o método userFind para verificar o login
            $this->userRepository->userFind($email, $password);

            // Se o método userFind não lançar exceções, o login foi bem-sucedido
            return new Response(302, ['Location' => '/']);
        } catch (\Exception $e) {
            // Se uma exceção for lançada, o login falhou
            $_SESSION['error_message'] = $e->getMessage();
            return new Response(302, ['Location' => '/login']);
        }
    }
}
