<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;

class VideoJsonListController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $videoList = array_map(function (Video $video): array{
            return [
                'url' => $video->url,
                'title' => $video->title,
                'file_path' => '/img/uploads/' . $video->getFilePath()

            ];
        },$this->videoRepository->allVideo());
        echo json_encode($videoList);
    }
}