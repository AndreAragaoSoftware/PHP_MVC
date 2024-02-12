<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;

class VideoFormController extends ControllerWithHtml implements Controller
{
    public function __construct(private VideoRepository $repository)
    {

    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->repository->oneVideo($id);
        }
        $this->rederTemplete(
            'video-form',
            ['video' => $video]
        );;

    }
}