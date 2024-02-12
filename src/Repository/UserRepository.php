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
        $correctPassword = password_verify($password, $userData['password'] ?? '');

        // Garantido que o usuário terá o password com a encriptação mais recente
        if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
           $statement = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
           $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
           $statement->bindValue(2, $userData['id']);
           $statement->execute();
        }

        // Verifica se tem acesso
        if ($correctPassword) {
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            $_SESSION['error_message'] = 'Usuário ou senha inválidos';
            header('Location: /login');
        }
    }

    public function hydrateUser(array $userData): User
    {
        $user = new User($userData['email'], $userData['password']);
        $user->setId($userData['id']);

        return $user;
    }
}
