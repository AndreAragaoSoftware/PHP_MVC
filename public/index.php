<?php

// Sempre chama a index.php
declare(strict_types=1);

use Andre\Mvc\Controller\Error404Controller;
use Andre\Mvc\Controller\LoginController;
use Andre\Mvc\Controller\Controller;
use Andre\Mvc\Controller\VideoEditController;
use Andre\Mvc\Controller\VideoFormController;
use Andre\Mvc\Controller\VideoJsonListController;
use Andre\Mvc\Controller\VideoListController;
use Andre\Mvc\Controller\VideoNewController;
use Andre\Mvc\Controller\VideoRemoveCoverController;
use Andre\Mvc\Controller\VideRemoveController;
use Andre\Mvc\Repository\UserRepository;
use Andre\Mvc\Repository\VideoRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new PDO('sqlite:D:\laragon\www\Alura\PHP\PHP_MVC\banco.sqlite');
$userRepository = new UserRepository($pdo);
$videoRepository = new VideoRepository($pdo);

/** @var Andre\Mvc\Controller\Controller $controller */

$routes = require_once __DIR__ . '/../config/routes.php';

// Configuração de dependecias
/** @var ContainerInterface $diContairner */
$diContairner = require_once  __DIR__ . '/../config/dependencies.php';

// Se não não achar vai ser /
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];


// Login
session_start();
if (!isset($_SESSION['logado']) && $pathInfo !== '/login') {
    header('Location: /login');
    return;
}

// Rotas
$key = "$httpMethod|$pathInfo";
if (array_key_exists($key, $routes)) {
    $controllerClass = $routes["$httpMethod|$pathInfo"];

    $controller = $diContairner->get($controllerClass);


}else {
        $controller = new Error404Controller();
    }

// Criação do objeto de requisição usando o ServerRequestCreator
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$request = $creator->fromGlobals();
/** @var RequestHandlerInterface $controller */
$response = $controller->handle($request);


http_response_code($response->getStatusCode());
foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header (sprintf('%s: %s', $name, $value), false);



    }
}
// Imprime o corpo da resposta
echo $response->getBody();

// Termina a execução do script após enviar a resposta
exit();



