<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\HtmlRendererTrait;
use Andre\Mvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Server\RequestHandlerInterface;


class VideoListController implements RequestHandlerInterface
{
    use HtmlRendererTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = $this->videoRepository->allVideo();
        $html =  $this->rederTemplete(
            'video-list',
                        ['videoList' => $videoList]
        );

        // Cria uma nova instância de Response com o HTML renderizado
        return new Response(body: $html);

    }
}