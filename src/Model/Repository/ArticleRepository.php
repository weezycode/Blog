<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use DateTime;
use App\Service\Database;
use App\Model\Entity\Article;
use App\Model\Entity\User;
use App\Model\Repository\UserRepository;

final class ArticleRepository
{
    private PDO $bdd;
    private $author;

    public function __construct(Database $database)
    {
        $this->bdd = $database->getPDO();
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?Article
    {
        $req = $this->bdd->prepare('SELECT * FROM article  where id = :id');
        $req->execute($criteria);
        // réfléchir à l'hydratation des entités;
        $data = $req->fetch(PDO::FETCH_ASSOC);
        $req = $this->bdd->prepare("SELECT pseudo FROM user Where id = '" . $data['id_author'] . "' ");
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);
        $req->execute();
        $pseudo = $req->fetch(PDO::FETCH_ASSOC);
        foreach ($pseudo as $value) {
        }
        if ($data['id'] === null) {
            header('Location: index.php?action=perdu');
        }
        return $data === null ? $data :
            new Article((int)$data['id'], (int)$data['id_author'], (string)$data['title'], (string)$data['short_content'], (string)$data['pseudo'] = $value, (string)$data['content'], $data['date_created'], $data['date_up']);
    }

    public function findAll(): ?array
    {


        $req = $this->bdd->prepare('SELECT * FROM article ');
        $req->execute();
        if ($req === null) {
            return null;
        }
        $posts = $req->fetchAll();

        $articles = [];

        foreach ($posts as $post) {
            $req = $this->bdd->prepare("SELECT pseudo FROM user Where id = '" . $post['id_author'] . "' ");
            $req->setFetchMode(PDO::FETCH_CLASS, User::class);
            $req->execute();
            $pseudos = $req->fetch(PDO::FETCH_ASSOC);
            foreach ($pseudos as $pseudo) {
            }
            if ($post['id'] === null) {
                header('Location: index.php?action=perdu');
            }

            $articles[] = new Article((int)$post['id'], (int)$post['id_author'], $post['title'], $post['short_content'], $post['pseudo'] = $pseudo, $post['content'], $post['date_created'], $post['date_up']);
        }
        return $articles;
    }

    public function createPost($idUser, $title, $shortContent, $content)
    {

        $data = [
            'id_author' => $idUser,
            'title' => $title,
            'short_content' => $shortContent,
            'content' => $content,
        ];
        $req = $this->bdd->prepare("INSERT INTO article (id_author, title, short_content, content, date_created) VALUES(:id_author, :title, :short_content, :content, NOW())");
        $req->execute($data);
    }

    public function updatePost($idPost, $idUser, $title, $shortContent, $content)
    {
        $data = [
            'id' => $idPost,
            'id_author' => $idUser,
            'title' => $title,
            'short_content' => $shortContent,
            'content' => $content,
        ];

        $req = $this->bdd->prepare('UPDATE article SET id_author =:id_author, title =:title, short_content =:short_content, content =:content, date_up =NOW() WHERE id =:id');


        $req->execute($data);
    }

    public function deletePost($idPost)
    {
        $data = ['id' => $idPost];
        $req = $this->bdd->prepare('DELETE  FROM article WHERE id = :id');
        $req->execute($data);
    }
}
