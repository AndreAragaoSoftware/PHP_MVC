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


$repository = new \Andre\Mvc\Repository\VideoRepository($pdo);


if ($repository->addVideo(new \Andre\Mvc\Entity\Video($url, $titulo)) === false){
    header("Location: /?sucesso=0");
}else {
    header("Location: /?sucesso=1");
}