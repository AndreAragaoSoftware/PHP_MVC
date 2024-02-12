<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Entity\Video;
use Andre\Mvc\Repository\VideoRepository;
use finfo;


class VideoNewController implements Controller
{
    public function __construct(private VideoRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if($url === false){
            $_SESSION['error_message'] = 'URL  inválida';
            header("Location: /novo-video");
            return;
        }
        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false){
            $_SESSION['error_message'] = 'Título não informado';
            header("Location: /novo-video");
            return;
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
            $_SESSION['error_message'] = 'Erro ao inserir novo vídeo';
            header("Location: /novo-video");
        } else {
            header("Location: /?sucesso=1");
        }

    }

}