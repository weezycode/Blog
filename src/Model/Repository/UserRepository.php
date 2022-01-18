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
        $req = $this->bdd->prepare('SELECT * FROM user WHERE  email=:email ');

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
        $req->execute();
    }

    public function delete(User $user)
    {
        $req = $this->bdd->prepare('DELETE FROM users WHERE id = :id ');
        $req->bindValue(':id', $user->getId());
        $req->execute();
    }

    public function findOneBy(array $criteria, array $orderBy = null): ?User
    {
        $req = $this->bdd->prepare("SELECT * FROM user WHERE email = :email");
        $data = $req->execute($criteria);
        $data = $req->fetch();

        // réfléchir à l'hydratation des entités;
        // var_dump($data);
        // die;

        return $data == null ? null : new User((int)$data['id'], (string)$data['email'], (string)$data['pseudo'],  (string)$data['passwd'], (string)$data['status'], $data['date_created']);
    }
}
