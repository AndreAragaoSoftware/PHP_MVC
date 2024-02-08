<?php

namespace Andre\Mvc\Repository;

use Andre\Mvc\Entity\Video;
use PDO;

class VideoRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function addVideo(Video $video): bool
    {
        $sql = "INSERT INTO videos (url, title, imagem_path) VALUES (?,?,?);";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $video->url);
        $statement->bindValue(2, $video->title);
        $statement->bindValue(3, $video->getFilePath());

        $result = $statement->execute();

        $id = $this->pdo->lastInsertId();
        $video->setId(intval($id));
        return $result;
    }

    public function removeVideo(int $id): bool
    {
        $sql = 'DELETE FROM videos WHERE id = ?';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $id);
        return $statement->execute();
    }

    public function updateVideo(Video $video): bool
    {
        // teste para saber se foi a dcionado uma imagem no edita
        $updateImageSql = '';
        if ($video->getFilePath() !== null) {
            $updateImageSql = ', imagem_path = :imagem_path';
        }


        $sql = "UPDATE videos SET
                  url = :url,
                  title = :title
                                    $updateImageSql
              WHERE id = :id;";


        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':url', $video->url);
        $statement->bindValue(':title', $video->title);
        $statement->bindValue(':id', $video->id, PDO::PARAM_INT);

        if($video->getFilePath() !== null) {
            $statement->bindValue(':imagem_path', $video->getFilePath());
        }

        return $statement->execute();
    }

    /** @return Video[] */
    public function allVideo(): array
    {
        $videoList = $this->pdo
            ->query('SELECT * FROM videos;')
            ->fetchAll(\PDO::FETCH_ASSOC);
        return array_map(
            $this->hydrateVideo(...),
            $videoList
        );
    }

    public function oneVideo(int $id)
    {
        $statement = $this->pdo->prepare('SELECT * FROM videos WHERE id = ?;');
        $statement->bindValue(1, $id, \PDO::PARAM_INT);
        $statement->execute();

        return $this->hydrateVideo($statement->fetch(\PDO::FETCH_ASSOC));
    }

    private function hydrateVideo(array $videoData): Video
    {
        $video = new Video($videoData['url'], $videoData['title']);
        $video->setId($videoData['id']);
        if($videoData['imagem_path'] !== null) {
            $video->setFilePath($videoData['imagem_path']);
        }

        return $video;
    }
}