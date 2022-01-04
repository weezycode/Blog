<?php

declare(strict_types=1);

namespace App\Model\Entity;

use DateTime;

final class User
{
    public function __construct(
        private int $id,
        private string $email,
        private string $pseudo,
        private string $passwdord,
        private string $status,
        private DateTime $dateInsert
    ) {
    }

    //-----------------------------------------Getters-----------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDateInsert()
    {
        return $this->dateInsert;
    }

    //---------------------------------Setters----------------------------------------------



    public function setPseudo(string $pseudo): self

    {
        $this->pseudo = $pseudo;
        return $this;
    }


    public function setEmail(string $email = NULL)
    {
        $this->email = $email;
        return $this;
    }



    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setStatus(string $status)
    {

        $this->status = $status;
        return $this;
    }

    public function setDateInsert(DateTime $dateInsert)
    {
        $this->dateInsert = $dateInsert;
        return $this;
    }
}
