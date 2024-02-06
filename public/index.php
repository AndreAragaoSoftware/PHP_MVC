<?php

// Sempre chama a index.php
declare(strict_types=1);

use Andre\Mvc\Controller\Error404Controller;
use Andre\Mvc\Controller\VideoEditController;
use Andre\Mvc\Controller\VideoFormController;
use Andre\Mvc\Controller\VideoListController;
use Andre\Mvc\Controller\VideoNewController;
use Andre\Mvc\Controller\VideRemoveController;
use Andre\Mvc\Controller\Controller;
use Andre\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');
$videoRepository = new VideoRepository($pdo);

/** @var Andre\Mvc\Controller\Controller $controller */

if(!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/'){
    $controller = new VideoListController($videoRepository);
} elseif (($_SERVER['PATH_INFO'] === '/novo-video')){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $controller = new VideoFormController($videoRepository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new VideoNewController($videoRepository);
    }
} elseif (($_SERVER['PATH_INFO'] === '/editar-video')){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        $controller = new VideoFormController($videoRepository);
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new VideoEditController($videoRepository);
    }
} elseif (($_SERVER['PATH_INFO'] === '/remover-video')) {
    $controller = new VideRemoveController($videoRepository);
}else {
    // Se não encontrar a pagina
    $controller = new Error404Controller();
}

/** @var Controller $controller */
$controller->processaRequisicao();
