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
            return;
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false){
            header("Location: /?sucesso=0");
            return;
        }
        $video  = new Video($url, $titulo);

        // teste pra saber se a imagem foi enviada
        if($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // refica se o arquivo foi enviado pelo formulário e move
            move_uploaded_file(
                $_FILES['image']['tmp_name'],
                __DIR__ . '/../../public/img/uploads/' . $_FILES['image']['name']
            );
            $video->setFilePath($_FILES['image']['name']);
        }

        if ($this->videoRepository->addVideo($video) === false) {
            header("Location: /?sucesso=0");
        } else {
            header("Location: /?sucesso=1");
        }

    }

}