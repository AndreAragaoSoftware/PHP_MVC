<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Helper\FlashMessageTrait;
use Andre\Mvc\Repository\VideoRepository;
use finfo;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class VideoNewController implements Controller
{
    use FlashMessageTrait;
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $postData = $request->getParsedBody();
        $url = filter_var($postData['url'], FILTER_VALIDATE_URL);
        $titulo = filter_var($postData['titulo']);

        if ($url === false || $titulo === false) {
            $this->addErrorMessage('URL ou título inválido');
            return new Response(400, [], 'URL ou título inválido');
        }
        $video  = new Video($url, $titulo);

        // teste para saber se a imagem foi enviada
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Pegando o nome temporário do arquivo
            $tempFileName = $_FILES['image']['tmp_name'];

            // Verifica se o arquivo é de imagem
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mineType = $finfo->file($tempFileName);



        if (str_starts_with($mineType, 'image/')) {
            $safeFileName = uniqid('Upload_') . pathinfo($_FILES['image']['name'], PATHINFO_BASENAME);
                // refica se o arquivo foi enviado pelo formulário e move
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/img/uploads/' . $safeFileName
                );
                $video->setFilePath($safeFileName);
            }
        }

        if ($this->videoRepository->addVideo($video) === false) {
            $this->addErrorMessage('Erro ao inserir novo vídeo');
            return new Response(302,
                ['Location' => '/novo-video']
            );
        } else {
            return new Response(302,
                ['Location' => '/']
            );
        }

    }

}