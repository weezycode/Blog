<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\Comment;

final class CommentRepository


{
    //protected $table = "comments";
    private PDO $bdd;



    public function __construct(Database $database)
    {

        $this->bdd = $database->getPDO();
    }

    public function findByPost(): ?array
    {


        $req = $this->bdd->prepare('SELECT * FROM comment INNER JOIN user ON comment.id_user = user.id WHERE id_article = id_article ORDER BY date_comment DESC');
        // $req->bindValue(':id_article', (int) $id);



        $req->execute();
        // $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        // if ($req === null) {
        //     return null;
        // }

        // réfléchir à l'hydratation des entités;

        $comment = $req->fetchAll();

        $comments = [];
        foreach ($comment as $come) {
            $comments[] = new Comment((int) $come['id'], (int)$come['id_user'], (string)$come['pseudo'], (int) $come['id_article'], (string)$come['content'], $come['date_comment'], (string)$come['display_status']);
        }

        //var_dump($comments);
        //die;
        return $comments;
    }

    public function findId($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM comment WHERE id = :id');

        $req->bindValue(':id', (int)$id);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        return $req->fetch();
    }

    public function findAll(): array
    {
        $req = $this->bdd->prepare('SELECT * FROM comment ORDER BY date_comment DESC');
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        return $req->fetch();
    }



    // public function creates(object $comment): bool
    // {
    //     // TODO à faire
    //     return false;
    // }

    public function create(Comment $comment)
    {
        $req = $this->bdd->prepare('INSERT INTO comment (id_user, content, id_article, display_status, date_comment) VALUES(:idUser, :content, :idArticle, :displayStatus, NOW())');

        $req->bindValue(':idUser', $comment->getIdUser());
        $req->bindValue(':content', $comment->getContent());
        $req->bindValue(':idArticle', $comment->getIdPost());
        $req->bindValue(':displayStatus', $comment->getDisplayStatus());

        $req->execute();
    }

    public function delete(Comment $comment)
    {
        $req = $this->bdd->prepare('DELETE FROM comment  WHERE id = :id');
        $req->bindValue(':id', $comment->getId());
        $req->execute();
    }
}
