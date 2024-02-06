<?php

// Sempre chama a index.php
declare(strict_types=1);

use Andre\Mvc\Controller\VideoEditController;
use Andre\Mvc\Controller\VideoFormController;
use Andre\Mvc\Controller\VideoListController;
use Andre\Mvc\Controller\VideoNewController;
use Andre\Mvc\Controller\VideRemoveController;
use Andre\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');
$videoRepository = new VideoRepository($pdo);

if(!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/'){
    $controller = new VideoListController($videoRepository);
    $controller->processaRequisicao();
} elseif (($_SERVER['PATH_INFO'] === '/novo-video')){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $controller = new VideoFormController($videoRepository);
        $controller->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new VideoNewController($videoRepository);
        $controller->processaRequisicao();
    }
} elseif (($_SERVER['PATH_INFO'] === '/editar-video')){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $controller = new VideoFormController($videoRepository);
        $controller->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new VideoEditController($videoRepository);
        $controller->processaRequisicao();
    }
} elseif (($_SERVER['PATH_INFO'] === '/remover-video')) {
    $controller = new VideRemoveController($videoRepository);
    $controller->processaRequisicao();
}else {
    // Se não encontrar a pagina
    http_response_code(404);
}
