<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\HtmlRendererTrait;
use Andre\Mvc\Repository\VideoRepository;


class VideoListController implements Controller
{
    use HtmlRendererTrait;

    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->allVideo();
        echo $this->rederTemplete(
            'video-list',
                        ['videoList' => $videoList]
        );

    }
}