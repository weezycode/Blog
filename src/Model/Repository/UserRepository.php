<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\User;

final class UserRepository
{
    private PDO $bdd;

    public function __construct(Database $database)
    {
        $this->bdd = $database->getPDO();
    }
    public function findAll(): array
    {
        $req = $this->bdd->query('SELECT * FROM user');

        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $req->fetchAll();
    }

    public function find(int $id)
    {
        $req = $this->bdd->prepare('SELECT * FROM user WHERE id = :id');

        $req->bindValue(':id', (int)$id);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $req->fetchAll();
    }

    public function findUser(string $email): User
    {
        $req = $this->bdd->prepare('SELECT * FROM  WHERE  email=:email ');

        $req->bindValue(':email', $email);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $req->fetch();
    }

    public function create(User $user)
    {
        $req = $this->bdd->prepare('INSERT INTO users (pseudo, email, passwd, status, date_created) VALUES(:pseudo, :email, :passwd, :status, :NOW()');
        $req->bindValue(':pseudo', $user->getPseudo());
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':passwd', $user->getPassword());
        $req->bindValue(':status', $user->getStatus());
    }

    public function delete(User $user)
    {
        $req = $this->bdd->prepare('DELETE FROM users WHERE id = :id ');
        $req->bindValue(':id', $user->getId());
        $req->execute();
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?User
    {
        $this->database->prepare('select * from user where email=:email');
        $data = $this->database->execute($criteria);

        // réfléchir à l'hydratation des entités;
        return $data === null ? null : new User((int)$data['id'], $data['pseudo'], $data['email'], $data['password'], $data['date_created'], $data['status']);
    }
}
