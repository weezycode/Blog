<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\Post;

final class PostRepository
{
    private $bdd;

    public function __construct()
    {
        $this->bdd->setFetchMode(PDO::FETCH_CLASS, Database::class);
    }


    public function findAll(): ?array
    {
        $req = $this->bdd->prepare('SELECT * FROM articles ORDER BY date_created DESC');
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Post::class);

        if ($req === null) {
            return null;
        }

        // réfléchir à l'hydratation des entités;
        $posts = $req->fetchAll();
        foreach ($posts as $post) {
            $userRepository = new UserRepository();
            $post->setIdAuthor($userRepository->find($post->getUserId()));
            //$posts[] = new Post((int)$post['id'], $post['title'], $post['text']);
        }

        return $posts;
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?Post
    {
        $this->database->prepare('select * from article where id=:id');
        $data = $this->database->execute($criteria);
        // réfléchir à l'hydratation des entités;
        return $data === null ? $data : new Post($data['id'], $data['title'], $data['content']);
    }
}
