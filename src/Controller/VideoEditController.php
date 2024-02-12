<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Helper\FlashMessageTrait;
use Andre\Mvc\Repository\VideoRepository;
use finfo;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VideoEditController implements RequestHandlerInterface
{
    use FlashMessageTrait;

    private VideoRepository $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);

        if ($id === null || $id === false) {
            $this->addErrorMessage('ID inválido');
            return new Response(302, [], 'ID inválido');
        }

        $postData = $request->getParsedBody();
        $url = filter_var($postData['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($postData['titulo']);


        if ($url === false || $titulo === false) {
            $this->addErrorMessage('URL ou título inválido');
            return new Response(302, [], 'URL ou título inválido');
        }

        // Atualiza os dados do vídeo com os valores fornecidos
        $video = new Video($url, $titulo);
        $video->setId($id);


        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];
        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $tmpFile = $uploadedImage->getStream()->getMetadata('uri');
            $mimeType = $finfo->file($tmpFile);

            if (str_starts_with($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . pathinfo($uploadedImage->getClientFilename(), PATHINFO_BASENAME);
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/uploads/' . $safeFileName);
                $video->setFilePath($safeFileName);
            }
        }

        $success = $this->videoRepository->updateVideo($video);
        if ($success === false) {
            $this->addErrorMessage('Erro ao atualizar o vídeo');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        return new Response(302, [
            'Location' => '/'
        ]);
    }


}
