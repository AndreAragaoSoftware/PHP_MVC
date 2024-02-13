<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;


class VideoListController implements RequestHandlerInterface
{

    public function __construct(
        private VideoRepository $videoRepository,
        private Engine $templates
    ){
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = $this->videoRepository->allVideo();
        $html =  $this->templates->render(
            'video-list',
                        ['videoList' => $videoList]
        );

        // Cria uma nova instância de Response com o HTML renderizado
        return new Response(body: $html);

    }
}