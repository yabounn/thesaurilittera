<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(
 *  fields={"email"},
 *  message="L'email est déjà utilisé !"
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
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contenir au minimum 8 caractères !")
     * 
     */
    private $password;

    /**
     * PAS DE ORM CAR confirm_password n'est pas dans la BDD
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe ne correspondent pas !")
     */
    private $confirm_password;

    /**
     * @ORM\Column(type="text")
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $commentPosted;

    public function __construct()
    {
        $this->commentPosted = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

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
    public function eraseCredentials() {}

    /**
     * Methode UserInterface 
     */
    public function getSalt() {}

    /**
     * Methode UserInterface 
     */
    public function getRoles() {
        return ['ROLE_USER'];
    }

    /**
     * @return Collection|Comment[]
     */
    public function getCommentPosted(): Collection
    {
        return $this->commentPosted;
    }

    public function addCommentPosted(Comment $commentPosted): self
    {
        if (!$this->commentPosted->contains($commentPosted)) {
            $this->commentPosted[] = $commentPosted;
            $commentPosted->setUser($this);
        }

        return $this;
    }

    public function removeCommentPosted(Comment $commentPosted): self
    {
        if ($this->commentPosted->contains($commentPosted)) {
            $this->commentPosted->removeElement($commentPosted);
            // set the owning side to null (unless already changed)
            if ($commentPosted->getUser() === $this) {
                $commentPosted->setUser(null);
            }
        }

        return $this;
    }
}
