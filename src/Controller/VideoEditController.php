<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;
use finfo;

class VideoEditController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit();
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            header('Location: /?sucesso=0');
            exit();
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false) {
            header('Location: /?sucesso=0');
            exit();
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

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

        if ($this->videoRepository->updateVideo($video)) {
            header('Location: /?sucesso=0');
        } else {
            header('Location: /?sucesso=1');
        }
    }
}