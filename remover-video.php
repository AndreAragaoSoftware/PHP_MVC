<?php
$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');

$id = $_GET['id'];


$repository = new \Andre\Mvc\Repository\VideoRepository($pdo);


if ($repository->removeVideo($id) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}