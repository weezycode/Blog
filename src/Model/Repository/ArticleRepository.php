<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\Article;
use DateTime;

final class ArticleRepository
{
    private PDO $bdd;

    public function __construct(Database $database)
    {
        $this->bdd = $database->getPDO();
    }





    public function findOneBy(array $criteria, array $orderBy = null): ?Article
    {
        $req = $this->bdd->prepare('select * from article inner join user on article.id_author = user.id  where article.id =:id ');
        $data = $req->execute($criteria);
        // réfléchir à l'hydratation des entités;
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data === null ? $data :
            new Article((int)$data['id'], (int)$data['id_author'], (string)$data['title'], (string)$data['short_content'], (string)$data['pseudo'], (string)$data['content'], $data['date_created'], $data['date_up']);
    }

    public function findAll(): ?array
    {
        $articles = [];
        $req = $this->bdd->prepare('SELECT * FROM article  ORDER BY date_up DESC');
        $req->execute();
        // $req->setFetchMode(PDO::FETCH_CLASS, Article::class);


        $posts = $req->fetchAll();
        // var_dump($posts);
        // die;
        foreach ($posts as $post) {

            // $userRepository = new UserRepository($post);
            // $post->setIdAuthor($userRepository->find($post->getUserId()));

            // $commentRepository = new CommentRepository($post);
            // $post->setContent($commentRepository->findByPost($post->getId()));

            $articles[] = new Article((int)$post['id'], (int)$post['id_author'], $post['title'], $post['short_content'], $post['pseudo'] = "pa", $post['content'], $post['date_created'], $post['date_up']);
        }
        return $articles;
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
