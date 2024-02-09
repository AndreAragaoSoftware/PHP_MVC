<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;

class VideoNewJsonController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
{
    //pegando os dados
    $request = file_get_contents('php://input');
    // tranformando em array
    $videoData = json_encode($request, true);
    $video = new Video($videoData['url'], $videoData['title']);
    $this->videoRepository->allVideo($video);

    // Rseposta criado
    http_response_code(201);
}
}