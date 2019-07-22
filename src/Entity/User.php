<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email est déjà utilisé !"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champs pseudo ne peut pas être vide !")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champs email ne peut pas être vide !")
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champs password ne peut pas être vide !")
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contenir au minimum 8 caractères !")
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Le champs ne peut pas être vide !")
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne correspondent pas !")
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Address", mappedBy="user", cascade={"persist", "remove"})
     */
    private $address;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $roles = [];

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->comment = new ArrayCollection();
        $this->books = new ArrayCollection();
        $this->cart = new ArrayCollection();
        $this->address = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }

    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;

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

    /**
     * Methode UserInterface 
     */
    public function eraseCredentials()
    { }

    /**
     * Methode UserInterface 
     */
    public function getSalt()
    { }

    /**
     * Methode UserInterface 
     */
    public function getRoles(): array
    {
        $roles = $this->roles;

        // if (empty($roles)) {
        //     $roles[] = 'ROLE_USER';
        // }
        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    /**
     * Supprimer un commentaire
     *
     * @param Comment $comment
     * @return self
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comment->contains($comment)) {
            $this->comment->removeElement($comment);

            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->addUser($this);
        }

        return $this;
    }

    /**
     * Supprimer un livre
     *
     * @param Book $book
     * @return self
     */
    public function removeBook(Book $book): self
    {
        if ($this->books->contains($book)) {
            $this->books->removeElement($book);
            $book->removeUser($this);
        }

        return $this;
    }


    public function getAddress(): Collection
    {
        return $this->address;
    }


    public function setAddress(Address $address): self
    {
        $this->address = $address;

        if ($this !== $address->getUser()) {
            $address->setUser($this);
        }

        return $this;
    }
}
