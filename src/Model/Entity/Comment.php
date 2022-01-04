<?php

declare(strict_types=1);

namespace App\Model\Entity;

use DateTime;

final class Comment
{
    public function __construct(
        private int $id,
        private int $IdUser,
        private string $pseudoUser, // TODO l'entity User serait plus approprié
        private int $idPost,
        private string $content,
        private DateTime $dateComment,
        private string $displayStatus


    ) {
    }

    //------------------------------------Getters------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdUser(): int
    {
        return $this->IdUser;
    }

    public function getPseudoUser(): string
    {
        return $this->pseudoUser;
    }

    public function getIdPost(): int
    {
        return $this->idPost;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDatecomment()
    {
        return $this->dateComment;
    }

    public function getDisplayStatus()
    {
        return $this->displayStatus;
    }


    //----------------------------------Setters-----------------------------------------

    // Set id user 

    /**
     * @param mixed $IdUser
     * 
     */


    public function setIdUser(int $IdUser)
    {
        return $this->IdUser = $IdUser;
    }

    // Set pseudo user 

    public function setPseudoUser(string $pseudoUser = NULL)
    {
        $this->pseudoUser = $pseudoUser;
        return $this;
    }

    // Set id article 

    /**
     * @param mixed $idPost
     * 
     */

    public function setIdPost(int $idPost)
    {
        return $this->idPost = $idPost;
    }

    // Set content 

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    // Set Date comment

    public function SetDatecomment(DateTime $dateComment)
    {
        $this->dateComment = $dateComment;
        return $this;
    }

    // Set Display status

    public function setDisplayStatus(string $displayStatus)
    {
        $this->displayStatus = $displayStatus;
        return $this;
    }
}
