<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoNewJsonController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
{
    //pegando os dados
    $request = $request->getBody()->getContents();
    // tranformando em array
    $videoData = json_decode($request, true);
    $video = new Video($videoData['url'], $videoData['title']);
    $this->videoRepository->allVideo($video);

    // Rseposta criado
    return new Response(201);
}
}