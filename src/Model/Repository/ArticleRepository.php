<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\Article;

final class ArticleRepository
{
    private PDO $bdd;

    public function __construct(Database $database)
    {
        $this->bdd = $database->getPDO();
    }


    public function findAll(): ?array
    {
        $req = $this->bdd->query('SELECT * FROM article ORDER BY date_created DESC');
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Article::class);

        if ($req === null) {
            return null;
        }

        // réfléchir à l'hydratation des entités;
        $posts = $req->fetchAll();
        foreach ($posts as $post) {
            $userRepository = new UserRepository($post);
            $post->setIdAuthor($userRepository->find($post->getUserId()));

            $commentRepository = new CommentRepository($post);
            $post->setContent($commentRepository->findByPost($post->getId()));
            //$posts[] = new Article((int)$post['id'], $post['title'], $post['text']);
        }

        return $this;
    }


    public function findOneBy(int $id): Article
    {
        $req = $this->bdd->prepare('SELECT * FROM article WHERE id=:id');
        $req->bindValue(':id', (int) $id);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Article::class);

        $post = $req->fetch();

        $userRepository = new UserRepository($post);
        $post->setIdAuthor($userRepository->find($post->getUserId()));

        $commentRepository = new CommentRepository($post);
        $post->setContent($commentRepository->findByPost($post->getId()));

        return $post;


        //$data = $this->database->execute($criteria);
        // réfléchir à l'hydratation des entités;
        //return $data === null ? $data : new Article($data['id'], $data['title'], $data['content']);
    }

    public function createPost(Article $post)
    {
        $req = $this->bdd->prepare('INSERT INTO article (id_author, title, short_content, content, date_created) VALUES(:id_author, :title, :short_content, :content, NOW(),');
        $req->bindValue('idAuthor', $post->getIdAuthor());
        $req->bindValue('title', $post->getTitle());
        $req->bindValue('shortContent', $post->getShortContent());
        $req->bindValue('content', $post->getContent());

        $req->execute();
    }

    public function updatePost(Article $post)
    {
        $req = $this->bdd->prepare('UPDATE article SET id_author = :idAuthor, title = :title, short_content = :shortContent, content = :content, date_up = :dateUp WHERE id = :id');
        $req->bindValue('idAuthor', $post->getIdAuthor());
        $req->bindValue('title', $post->getTitle());
        $req->bindValue('shortContent', $post->getShortContent());
        $req->bindValue('content', $post->getContent());
        $req->bindValue('dateUp', $post->getDateUp());

        $req->execute();
    }

    public function deletePost(Article $post)
    {
        $req = $this->bdd->prepare('DELETE FROM article WHERE id = :id');
        $req->bindValue(':id', $post->getId());
        $req->execute();
    }
}
