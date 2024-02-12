<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\HtmlRendererTrait;
use Andre\Mvc\Repository\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Nyholm\Psr7\Response;


class VideoListController implements Controller
{
    use HtmlRendererTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
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