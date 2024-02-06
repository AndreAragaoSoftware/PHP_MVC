<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;

class VideoNewController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if($url === false){
            header("Location: /?sucesso=0");
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false){
            header("Location: /?sucesso=0");
            exit();
        }


        if ($this->videoRepository->addVideo(new Video($url, $titulo)) === false) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }

    }

}