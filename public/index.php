<?php

// Sempre chama a index.php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

if(!array_key_exists('PATH_INFO', $_SERVER) || $_SERVER['PATH_INFO'] === '/'){
    require_once __DIR__ . '/../listagem-cursos.php';
} elseif (($_SERVER['PATH_INFO'] === '/novo-video')){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once __DIR__ . '/../formulario.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../novo-video.php';
    }
} elseif (($_SERVER['PATH_INFO'] === '/editar-video')){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once __DIR__ . '/../formulario.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once __DIR__ . '/../editar-video.php';
    }
}elseif (($_SERVER['PATH_INFO'] === '/remover-video')) {
    require_once __DIR__ . '/../remover-video.php';
}else {
    // Se não encontrar a pagina
    http_response_code(404);
}
