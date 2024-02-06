<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\VideoRepository;


class VideoListController implements Controller
{


    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->allVideo();
        require_once __DIR__ . '/../../views/video-list.php';

    }
}