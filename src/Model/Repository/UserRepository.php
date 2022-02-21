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
    public function findAll()
    {
        $req = $this->bdd->query('SELECT * FROM user');

        $req->setFetchMode(PDO::FETCH_CLASS, User::class);
        $req->execute();
    }


    public function findUser()
    {
        $req = $this->bdd->prepare('SELECT * FROM user ');
        $req->execute();
        $users = $req->fetchAll(PDO::FETCH_ASSOC);
        $arrayUsers = [];
        foreach ($users as $data) {
            $arrayUsers[] = new User((int)$data['id'], (string)$data['email'], (string)$data['pseudo'],  (string)$data['passwd'], (string)$data['status'], $data['date_created']);
        }
        return $arrayUsers;
    }

    public function createUser($pseudo, $email, $passwd)
    {
        $data = [
            'pseudo' => $pseudo,
            'email' => $email,
            'passwd' => $passwd,
            'status' => 'member',

        ];

        $req = $this->bdd->prepare("INSERT INTO user (pseudo, email, passwd, status,date_created)VALUES(:pseudo, :email, :passwd, :status, NOW())");

        $req->execute($data);
    }

    public function delete($idUser)
    {
        $data = [
            'id' => $idUser,
        ];
        $req = $this->bdd->prepare('DELETE FROM user WHERE id = :id ');
        $req->execute($data);
    }

    public function updateStatusUser($idUser, $status)
    {
        $data = [
            'id' => $idUser,
            'status' => $status,
        ];
        $req = $this->bdd->prepare('UPDATE user SET status =:status WHERE id =:id');
        $req->execute($data);
    }


    public function findOneBy(array $criteria, array $orderBy = null): ?User
    {
        $req = $this->bdd->prepare("SELECT * FROM user WHERE email = :email");
        $data = $req->execute($criteria);
        $data = $req->fetch();

        return $data == null ? null : new User((int)$data['id'], (string)$data['email'], (string)$data['pseudo'],  (string)$data['passwd'], (string)$data['status'], $data['date_created']);
    }

    public function findOneById(array $criteria, array $orderBy = null): ?User
    {
        $req = $this->bdd->prepare("SELECT * FROM user WHERE id = :id");
        $data = $req->execute($criteria);
        $data = $req->fetch();

        return $data == null ? null : new User((int)$data['id'], (string)$data['email'], (string)$data['pseudo'],  (string)$data['passwd'], (string)$data['status'], $data['date_created']);
    }
}
