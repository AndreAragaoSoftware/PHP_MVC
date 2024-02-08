<?php
namespace Andre\Mvc\Repository;

use Andre\Mvc\Entity\User;
use PDO;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function userFind(string $email, string $password): void
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = ?;");
        $statement->bindValue(1, $email);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        // Verifica se encontrou o usuário
        if ($userData) {
            // Verifica se a senha está correta
            if (password_verify($password, $userData['password'])) {
                $_SESSION['logado'] = true;
                // Senha correta, redireciona para a página principal
                header('Location: /');
            } else {
                // Senha incorreta, redireciona de volta para a página de login com erro
                header('Location: /login?sucesso=0');
            }
        } else {
            // Usuário não encontrado, redireciona de volta para a página de login com erro
            header('Location: /login?sucesso=0');
        }
    }

    public function hydrateUser(array $userData): User
    {
        $user = new User($userData['email'], $userData['password']);
        $user->setId($userData['id']);

        return $user;
    }
}
