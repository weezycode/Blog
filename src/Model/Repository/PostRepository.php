<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Entity\Post;
use App\Service\Database;

final class PostRepository
{
    public function __construct(private Database $database)
    {
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?Post
    {
        $this->database->prepare('select * from post where id=:id');
        $data = $this->database->execute($criteria);
        // réfléchir à l'hydratation des entités;
        return $data === null ? $data : new Post($data['id'], $data['title'], $data['text']);
    }

    public function findAll(): ?array
    {
        $this->database->prepare('select * from post');
        $data = $this->database->execute();

        if ($data === null) {
            return null;
        }

        // réfléchir à l'hydratation des entités;
        $posts = [];
        foreach ($data as $post) {
            $posts[] = new Post((int)$post['id'], $post['title'], $post['text']);
        }

        return $posts;
    }
}
