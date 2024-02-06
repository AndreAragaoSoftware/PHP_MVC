<?php

$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if($url === false){
    header("Location: /?sucesso=0");
    exit();
}
$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false){
    header("Location: /?sucesso=0");
    exit();
}

$sql = "INSERT INTO videos (url, title) VALUES (?,?);";
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $url);
$statement->bindValue(2, $titulo);


if ($statement->execute() === false){
    header("Location: /?sucesso=0");
}else {
    header("Location: /?sucesso=1");
}