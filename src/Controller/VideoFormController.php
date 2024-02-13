<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;
use League\Plates\Engine;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController  implements RequestHandlerInterface
{
    public function __construct(
        private VideoRepository $repository,
        private Engine $templates
    )
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        /** @var ?Video $video */
        $video = null;
        if ($id !== false && $id !== null) {
            $video = $this->repository->oneVideo($id);
        }

        // Renderiza o formulário de vídeo e inclui os dados do vídeo no contexto
        $html = $this->templates->render('video-form', ['video' => $video]);

        // Retorna a resposta com o HTML renderizado
        return new Response(
            200,
            [],
            $html
        );
    }

}