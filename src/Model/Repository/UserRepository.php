<?php

declare(strict_types=1);

namespace App\Model\Repository;

use PDO;
use App\Service\Database;
use App\Model\Entity\User;

final class UserRepository
{
    private $bdd;

    public function __construct()
    {
        $this->bdd->setFetchMode(PDO::FETCH_CLASS, Database::class);
    }

    public function findAll(): array
    {
        $req = $this->db->query('SELECT * FROM users');

        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $req->fetchAll();
    }

    public function find(int $id)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE id = :id');

        $req->bindValue(':id', (int)$id);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $req->fetch();
    }

    public function findUser(string $email): User
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE  email=:email ');

        $req->bindValue(':email', $email);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);

        return $req->fetch();
    }

    public function create(User $user)
    {
        $req = $this->bdd->prepare('INSERT IN TO users (pseudo, email, passwd, status, date_created) VALUES(:pseudo, :email, :passwd, :status, :NOW()');
        $req->binValue(':pseudo', $user->getPseudo());
        $req->binValue(':email', $user->getEmail());
        $req->binValue(':passwd', $user->getPassword());
        $req->binValue(':status', $user->getStatus());
    }

    public function delete(User $user)
    {
        $req = $this->bdd->prepare('DELETE FROM users WHERE id = :id ');
        $req->binValue(':id', $user->getId());
        $req->execute();
    }

    // public function findOneBy(array $criteria, array $orderBy = null): ?User
    // {
    //     $this->database->prepare('select * from user where email=:email');
    //     $data = $this->database->execute($criteria);

    //     // réfléchir à l'hydratation des entités;
    //     return $data === null ? null : new user((int)$data['id'], $data['pseudo'], $data['email'], $data['password']);
    // }
}
