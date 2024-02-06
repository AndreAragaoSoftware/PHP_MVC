<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\VideoRepository;

class VideRemoveController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }
    public function processaRequisicao(): void
    {
        $id = $_GET['id'];

        if ($this->videoRepository->removeVideo($id) === false) {
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }

}