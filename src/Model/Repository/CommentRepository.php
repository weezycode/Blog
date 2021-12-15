<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Service\Database;
use App\Model\Entity\Comment;

final class CommentRepository
{
    public function __construct(private Database $database)
    {
    }

    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): ?array
    {
        $this->database->prepare('select * from comment where idPost=:idPost');
        $data = $this->database->execute($criteria);

        if ($data === null) {
            return null;
        }

        // réfléchir à l'hydratation des entités;
        $comments = [];
        foreach ($data as $comment) {
            $comments[] = new Comment((int)$comment['id'], $comment['pseudo'], $comment['text'], (int)$comment['idPost']);
        }

        return $comments;
    }

    public function create(object $comment): bool
    {
        // TODO à faire
        return false;
    }
}
