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

    /**
     * Return Comments from a post
     *
     * @param $postId
     * @return array|mixed
     */
    public function findAll()
    {
        $req = $this->bdd->prepare('SELECT comment.id, comment.id_user, content, display_status, id_article, user.pseudo, date_comment FROM comment INNER JOIN user on comment.id_user=user.id WHERE id_article = id_article ORDER BY date_comment DESC');

        $req->execute();
        $comment = $req->fetchAll();

        $comments = [];

        foreach ($comment as $come) {

            $comments[] = new Comment((int) $come['id'], (int)$come['id_user'], (string)$come['pseudo'], (int) $come['id_article'], (string)$come['content'], $come['date_comment'], (string)$come['display_status']);
        }


        return $comments;
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

    public function updateComment($id)
    {
        $data = [
            'id' => $id,
            'display_status' => 'granted'
        ];
        $req = $this->bdd->prepare('UPDATE comment SET display_status =:display_status WHERE id =:id');
        $req->execute($data);
    }

    public function deleteComment($id)
    {
        $data = [
            'id' => $id,
        ];
        $req = $this->bdd->prepare('DELETE FROM comment  WHERE id = :id');
        $req->execute($data);
    }
}
