<?php
$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');

$id = $_GET['id'];


$id = $_GET['id'];
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);

if ($statement->execute() === false) {
    header('Location: /index.php?sucesso=0');
} else {
    header('Location: /index.php?sucesso=1');
}