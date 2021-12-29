<?php

declare(strict_types=1);

namespace App\Model\Entity;

use DateTime;

final class Post
{


    public function __construct(
        private int $id,
        private int $id_author,
        private string $title,
        private string $short_content,
        private string $content,
        private DateTime $date_created,
        private DateTime $date_up

    ) {
    }

    //-------------------------------------------Getters--------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdAuthor(): int
    {
        return $this->id_author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getShortContent(): string
    {
        return $this->short_content;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function getDateUp()
    {
        return $this->date_up;
    }

    //------------------------------------------Setters------------------------------------

    public function setId(int $id)
    {
        if ($this->id > 0) {
            return $this->id = $id;
        }
    }

    /**
     * @param mixed $id_author
     * 
     */

    public function setIdAuthor(int $id_author)
    {
        if (isset($this->id_author)) {
            return $this->id_author = htmlspecialchars($id_author);
        }
    }



    public function setTitle(string $title): self
    {

        if (isset($this->title))
            $this->title = htmlspecialchars($title);
        return $this;
    }

    public function setShortContent(string $short_content): self
    {
        if (isset($this->short_content))
            $this->title = htmlspecialchars($short_content);
        return $this;
    }

    public function setContent(string $content): self
    {
        if (isset($this->content))
            $this->title = htmlspecialchars($content);
        return $this;
    }


    public function SetDateCreated($date_created)
    {
        if (isset($this->date_created)) {
            return $this->date_created = htmlspecialchars($date_created);
        } else {
            $date_created = new DateTime();
        }
    }

    public function SetDateUp($date_up)
    {
        if (isset($this->date_up)) {
            return $this->date_up = htmlspecialchars($date_up);
        } else {
            $date_up = new DateTime();
        }
    }
}
