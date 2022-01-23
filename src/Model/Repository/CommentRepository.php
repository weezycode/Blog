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

    public function findByPost(int $idPost): ?array
    {
        $req = $this->bdd->prepare("SELECT * FROM comment INNER JOIN user ON comment.id_user = user.id WHERE id_article = :id_article AND display_status = 'granted' ORDER BY date_comment DESC");
        $req->bindValue(':id_article', $idPost);
        $req->execute();
        $comment = $req->fetchAll();
        $comments = [];
        foreach ($comment as $come) {
            $comments[] = new Comment((int) $come['id'], (int)$come['id_user'], (string)$come['pseudo'], (int) $come['id_article'], (string)$come['content'], $come['date_comment'], (string)$come['display_status']);
        }
        return $comments;
    }

    public function findAll(): array
    {
        $req = $this->bdd->prepare('SELECT * FROM comment ORDER BY date_comment DESC');
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Comment::class);

        return $req->fetch();
    }

    public function addComment($idUser, $idPost, $content)
    {
        $data = [
            'id_user' => $idUser,
            'id_article' => $idPost,
            'content' => $content,
            'display_status' => 'pending',

        ];

        $req = $this->bdd->prepare('INSERT INTO comment (id_user, id_article, content, date_comment, display_status) VALUES
        (:id_user, :id_article, :content, NOW(),:display_status)');

        $req->execute($data);
    }

    public function delete(Comment $comment)
    {
        $req = $this->bdd->prepare('DELETE FROM comment  WHERE id = :id');
        $req->bindValue(':id', $comment->getId());
        $req->execute();
    }
}
