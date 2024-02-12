<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Helper\HtmlRendererTrait;
use Andre\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoFormController  implements RequestHandlerInterface
{
    use HtmlRendererTrait;
    public function __construct(private VideoRepository $repository)
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
        $html = $this->rederTemplete('video-form', ['video' => $video]);

        // Retorna a resposta com o HTML renderizado
        return new Response(
            200,
            [],
            $html
        );
    }

}