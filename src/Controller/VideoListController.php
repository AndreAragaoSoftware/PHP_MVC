<?php

namespace Andre\Mvc\Controller;

use Andre\Mvc\Repository\VideoRepository;
use PDO;

class VideoListController
{


    public function __construct(private VideoRepository $videoRepository)
    {

    }

    public function processaRequisicao(): void
    {
        $videoList = $this->videoRepository->allVideo();
        require_once __DIR__ . '/../../inicio-html.php'; ?>


        <ul class="videos__container">
        <?php foreach ($videoList as $video): ?>
            <li class="videos__item">
                <iframe width="100%" height="72%" src="<?= $video->url; ?>"
                        title="YouTube video player"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                <div class="descricao-video">
                    <h3><?= $video->title; ?></h3>
                </div>
                    <div class="acoes-video">
                        <a href="/editar-video?id=<?= $video->id; ?>">Editar</a>
                        <a href="/remover-video?id=<?= $video->id; ?>">Excluir</a>
                    </div>

            </li>
        <?php endforeach; ?>
    </ul>
<?php require_once __DIR__ . '/../../fim-html.php';
    }
}