<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoJsonListController implements RequestHandlerInterface
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $videoList = array_map(function (Video $video): array{
            return [
                'url' => $video->url,
                'title' => $video->title,
                'file_path' => '/img/uploads/' . $video->getFilePath()

            ];
        },$this->videoRepository->allVideo());
        return new  Response(200, [
            'Content-type' => 'application/json'

        ], json_encode($videoList));
    }
}