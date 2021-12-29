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
        private DateTime $date_insert
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
        return $this->date_insert;
    }

    //---------------------------------Setters----------------------------------------------

    public function setUserId(int $id)
    {
        if ($this->id > 0) {
            return $this->id = $id;
        }
    }

    public function setPseudo(string $pseudo): self
    {
        if (isset($this->pseudo)) {
            $this->pseudo = htmlspecialchars($pseudo);
            return $this;
        }
    }


    public function setEmail(string $email = NULL)
    {
        if (!isset($this->email)) {
            return;
        } else if (filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->email = htmlspecialchars($email);
            return $this;
        }
    }



    public function setPassword(string $password): self
    {
        if (isset($this->password)) {
            $this->password = htmlspecialchars($password);
            return $this;
        }
    }

    public function setStatus(string $status)
    {
        if (isset($this->status) && ($this->status == UserStatus::member) || ($this->status == UserStatus::admin) || ($this->status == UserStatus::superadmin)) {
            $this->status = htmlspecialchars($status);
            return $this;
        }
    }

    public function setDateInsert()
    {
        if ($this->id) {
            return $this->date_insert = $this->getDateInsert();
        } else {
            return date('Y-m-d H:i:s');
        }
    }
}
