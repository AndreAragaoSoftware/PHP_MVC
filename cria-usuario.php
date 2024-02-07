<?php
$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');

// Pegando do terminal
$email = $argv[1];
$password = $argv[2];

// criando o hash para deixar o dados da senha mais seguras
$hash = password_hash($password, PASSWORD_ARGON2ID);

$sql = "INSERT INTO users (email, password) VALUES (?, ?);";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $email);
$statement->bindValue(2, $hash);
$statement->execute();

