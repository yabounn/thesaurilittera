<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleComment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titleBook;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usernameComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleComment(): ?string
    {
        return $this->titleComment;
    }

    public function setTitleComment(string $titleComment): self
    {
        $this->titleComment = $titleComment;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTitleBook(): ?string
    {
        return $this->titleBook;
    }

    public function setTitleBook(string $titleBook): self
    {
        $this->titleBook = $titleBook;

        return $this;
    }

    public function getUsernameComment(): ?string
    {
        return $this->usernameComment;
    }

    public function setUsernameComment(string $usernameComment): self
    {
        $this->usernameComment = $usernameComment;

        return $this;
    }
}
