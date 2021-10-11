<?php

namespace App\Entity;

use App\Repository\ContactusRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactusRepository::class)
 */
class Contactus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="merci de saisir un prénom")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="merci de saisir un nom")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="merci de saisir un email")
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(message="merci de saisir un message")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

        
    public function __construct()
    {
        
        $this->createdAt = new DateTimeImmutable();
       
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
