<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\FlashMessageTrait;
use Andre\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideRemoveController implements RequestHandlerInterface
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id=== false){
            $this->addErrorMessage('ID inválido');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        if ($this->videoRepository->removeVideo($id) === false) {
            $this->addErrorMessage('Erro ao remover vídeo');
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            return new Response(200, [
                'Location' => '/'
            ]);
        }
    }

}