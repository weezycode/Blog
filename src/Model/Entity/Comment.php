<?php

declare(strict_types=1);

namespace App\Model\Entity;

use DateTime;

final class Comment
{
    public function __construct(
        private int $id,
        private int $id_user,
        private string $pseudo_user, // TODO l'entity User serait plus approprié
        private int $id_post,
        private string $content,
        private DateTime $date_comment,
        private string $display_status


    ) {
    }

    //------------------------------------Getters------------------------------------------

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

    public function getDatecomment()
    {
        return $this->date_comment;
    }

    public function getDisplayStatus()
    {
        return $this->display_status;
    }


    //----------------------------------Setters-----------------------------------------
    public function setId(int $id)
    {
        if ($id > 0) {
            return $this->id = $id;
        }
    }


    // Set id user 

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

    // Set pseudo user 

    public function setPseudoUser(string $pseudo_user = NULL)
    {
        if (is_string($pseudo_user)) {
            return $this->pseudo_user = $pseudo_user;
        } else {
            if (is_int($pseudo_user)) {
                return $this->pseudo_user = $this->getIdUser();
            }
        }
    }

    // Set id article 

    /**
     * @param mixed $id_post
     * 
     */

    public function setIdPost(int $id_post)
    {
        if (isset($this->id_post) && $this->id_post > 0) {
            return $this->id_post = htmlspecialchars($id_post);
        }
    }

    // Set content 

    public function setContent(string $content): self
    {
        if (isset($this->content)) {
            $this->content = htmlspecialchars($content);
            return $this;
        }
    }

    // Set Date comment

    public function SetDatecomment($date_comment)
    {
        if (isset($this->date_comment)) {
            return $this->date_comment = $date_comment;
        } else {
            $date_comment = new DateTime();
        }
    }

    // Set Display status

    public function setDisplayStatus($display_status)
    {
        return $this->display_status = htmlspecialchars($display_status);
    }
}
