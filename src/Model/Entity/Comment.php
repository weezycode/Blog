<?php

declare(strict_types=1);

namespace App\Model\Entity;


final class Comment
{
    public function __construct(
        private int $id,
        private int $id_user,
        private string $pseudo_user, // TODO l'entity User serait plus approprié
        private int $id_post,
        private string $content,
        private $date_insert,
        private $date_update,
        private string $display_status


    ) {
    }

    // Getters

    public function getId(): int
    {
        return $this->id;
    }
    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function getPseudoUser(): string
    {
        return $this->pseudo_user;
    }
    public function getIdPost(): int
    {
        return $this->id_post;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateInsert()
    {
        return $this->date_insert;
    }

    public function getUpdate()
    {
        return $this->date_update;
    }

    public function getDisplayStatus()
    {
        return $this->display_status;
    }




    //Setters
    /**
     * @param mixed $id_user
     * 
     */

    public function setIdUser(int $id_user)
    {
        if (isset($this->id_user)) {
            return $this->id_user = htmlspecialchars($id_user);
        }
    }

    public function setPseudoUser()
    {
    }

    public function setContent(string $content): self
    {
        if (isset($this->content)) {
            $this->content = htmlspecialchars($content);
            return $this;
        }
    }
}
