<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\VideoRepository;

class VideoRemoveCoverController implements Controller
{

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = $_GET['id'];

        if ($this->videoRepository->removeCover($id) === false) {
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }

}