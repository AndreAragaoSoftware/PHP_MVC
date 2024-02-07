<?php

return [
    'GET|/' => \Andre\Mvc\Controller\VideoListController::class,
    'GET|/novo-video' => \Andre\Mvc\Controller\VideoFormController::class,
    'POST|/novo-video' => \Andre\Mvc\Controller\VideoNewController::class,
    'GET|/editar-video' => \Andre\Mvc\Controller\VideoFormController::class,
    'POST|/editar-video' => \Andre\Mvc\Controller\VideoEditController::class,
    'GET|/remover-video' => \Andre\Mvc\Controller\VideRemoveController::class,
    'GET|/login' => \Andre\Mvc\Controller\LoginFormController::class,
    'POST|/login' => \Andre\Mvc\Controller\LoginController::class
];