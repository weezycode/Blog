<?php

declare(strict_types=1);

namespace App\Model\Entity;

use DateTime;

final class Article
{


    public function __construct(
        private int $id,
        private int $idAuthor,
        private string $title,
        private string $shortContent,
        private string $pseudo,
        private string $content,
        private  $dateCreated,
        private  $dateUp

    ) {
    }

    //-------------------------------------------Getters--------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getIdAuthor(): int
    {
        return $this->idAuthor;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getShortContent(): string
    {
        return $this->shortContent;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function getDateUp()
    {
        return $this->dateUp;
    }

    //------------------------------------------Setters------------------------------------



    /**
     * @param mixed $idAuthor
     * 
     */


    public function setIdAuthor(int $idAuthor)
    {

        $this->idAuthor = $idAuthor;
        return $this;
    }



    public function setTitle(string $title): self
    {

        $this->title = $title;
        return $this;
    }

    public function setShortContent(string $shortContent): self
    {

        $this->sortContent = $shortContent;
        return $this;
    }


    public function setPseudo(string $pseudo): self
    {

        $this->pseudo = $pseudo;
        return $this;
    }

    public function setContent(string $content): self
    {

        $this->content = $content;
        return $this;
    }


    public function setDateCreated(DateTime $dateCreated)
    {

        $this->dateCreated = $dateCreated;
        return $this;
    }

    public function setDateUp(DateTime $dateUp)
    {
        $this->dateUp = $dateUp;
        return $this;
    }
}
