<?php


use Andre\Mvc\Repository\UserRepository;
use Andre\Mvc\Repository\VideoRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

$buider = new ContainerBuilder();
$buider->addDefinitions([
    PDO::class => function (): PDO {
        $dpParth = __DIR__ . '/../banco.sqlite';
        return new PDO("sqlite:$dpParth");
    },
    UserRepository::class => DI\autowire(),
    VideoRepository::class => DI\autowire(),
    \League\Plates\Engine::class => function () {
        $templatePath = __DIR__ . '/../views';
        return new \League\Plates\Engine($templatePath);
    }
]);

/** @var ContainerInterface $container */
try {
    $container = $buider->build();
} catch (Exception $e) {
}

return $container;