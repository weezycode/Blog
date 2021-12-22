<?php

declare(strict_types=1);

namespace App\Model\Repository;

use App\Service\Database;
use App\Model\Entity\User;

final class UserRepository
{
    public function __construct(private Database $database)
    {
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?User
    {
        $this->database->prepare('select * from user where email=:email');
        $data = $this->database->execute($criteria);

        // réfléchir à l'hydratation des entités;
        return $data === null ? null : new user((int)$data['id'], $data['pseudo'], $data['email'], $data['password']);
    }
}
