<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Helper\HtmlRendererTrait;
use Andre\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VideoFormController  implements Controller
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $repository)
    {

    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->repository->oneVideo($id);
        }
         $html = $this->rederTemplete(
            'video-form',
            ['video' => $video]
        );;
        return new Response(200, body: $html);
    }
}