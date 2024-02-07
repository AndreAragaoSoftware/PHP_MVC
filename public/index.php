<?php

// Sempre chama a index.php
declare(strict_types=1);

use Andre\Mvc\Controller\Error404Controller;
use Andre\Mvc\Controller\VideoEditController;
use Andre\Mvc\Controller\VideoFormController;
use Andre\Mvc\Controller\VideoListController;
use Andre\Mvc\Controller\VideoNewController;
use Andre\Mvc\Controller\VideRemoveController;
use Andre\Mvc\Controller\LoginController; // Adicionei a classe LoginController
use Andre\Mvc\Controller\Controller;
use Andre\Mvc\Repository\UserRepository;
use Andre\Mvc\Repository\VideoRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');
$videoRepository = new VideoRepository($pdo);
$userRepository = new UserRepository($pdo);

/** @var Andre\Mvc\Controller\Controller $controller */

$routes = require_once __DIR__ . '/../config/routes.php';

// Se não não achar vai ser /
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    if (class_exists($controllerClass)) {
        if ($controllerClass === UserRepository::class) {
            $controller = new $controllerClass($userRepository);
        } elseif ($controllerClass === VideoRepository::class || $controllerClass === VideoListController::class) {
            $controller = new $controllerClass($videoRepository);
        } elseif ($controllerClass === LoginController::class) {
            $controller = new $controllerClass($userRepository);
        } else {
            // Se não for um repositório ou VideoListController ou LoginController, instanciamos sem argumentos
            $controller = new $controllerClass();
        }
    } else {
        $controller = new Error404Controller();
    }

    /** @var Controller $controller */
    $controller->processaRequisicao();
} else {
    $controller = new Error404Controller();
    $controller->processaRequisicao();
}
