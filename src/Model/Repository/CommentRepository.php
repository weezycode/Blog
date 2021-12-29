<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\Comment;

final class CommentRepository


{
    //protected $table = "comments";
    private $bdd;

    public function __construct()
    {
        $this->bdd->setFetchMode(PDO::FETCH_CLASS, Database::class);
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
        $req = $this->bdd->prepare('SELECT * FROM comments ORDER BY date_comment DESC');

        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        return $req->fetch();
    }

    public function findByPost($id)
    {
        $data = $this->bdd->prepare('SELECT * from comments where id_article = :id_article ORDER BY date_comment DESC');
        $data->binValue(':id_article', (int) $id);
        $data->execute();
        $data->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        if ($data === null) {
            return null;
        }

        // réfléchir à l'hydratation des entités;
        $comment = $this->data->fetchAll();
        foreach ($comment as $comments) {
            $commentRepository = new UserRepository();
            $comments->setPseudoUser($commentRepository->find($comments->getUserId()));
        }
        return $comments;
    }

    // public function creates(object $comment): bool
    // {
    //     // TODO à faire
    //     return false;
    // }

    public function create(Comment $comment)
    {
        $req = $this->bdd->prepare('INSERT INTO comments (id_user, content, id_article, display_status, date_comment) VALUES(:id_user, :content, :id_article, :display_status, NOW())');

        $req->bindValue(':id_user', $comment->getIdUser());
        $req->bindValue(':content', $comment->getContent());
        $req->bindValue(':id_article', $comment->getIdPost());
        $req->bindValue(':display_status', $comment->getDisplayStatus());

        $req->execute();
    }

    public function delete(Comment $comment)
    {
        $req = $this->bdd->prepare('DELETE FROM comments WHERE id = :id');
        $req->bindValue(':id', $comment->getId());
        $req->execute();
    }
}
