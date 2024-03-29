<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Helper\FlashMessageTrait;
use Andre\Mvc\Repository\VideoRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoRemoveCoverController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $_GET['id'];

        if ($this->videoRepository->removeCover($id) === false) {
            $this->addErrorMessage('Error ao tentar adicionar video');
            return new Response(302,
                ['Location' => '/']
            );
        } else {
            return new Response(200,
                ['Location' => '/']
            );
        }
    }

}