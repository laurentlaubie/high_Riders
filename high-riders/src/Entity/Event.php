<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2100)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $opening_hours;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $closed_hours;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $difficulty;

    /**
     * @ORM\Column(type="date")
     */
    private $date_event;

    /**
     * @ORM\Column(type="string", length=2100, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $accessibility;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $participation_user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $e_like;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type_event;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOpeningHours(): ?\DateTimeInterface
    {
        return $this->opening_hours;
    }

    public function setOpeningHours(?\DateTimeInterface $opening_hours): self
    {
        $this->opening_hours = $opening_hours;

        return $this;
    }

    public function getClosedHours(): ?\DateTimeInterface
    {
        return $this->closed_hours;
    }

    public function setClosedHours(?\DateTimeInterface $closed_hours): self
    {
        $this->closed_hours = $closed_hours;

        return $this;
    }

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(?int $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->date_event;
    }

    public function setDateEvent(\DateTimeInterface $date_event): self
    {
        $this->date_event = $date_event;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAccessibility(): ?string
    {
        return $this->accessibility;
    }

    public function setAccessibility(?string $accessibility): self
    {
        $this->accessibility = $accessibility;

        return $this;
    }

    public function getParticipationUser(): ?int
    {
        return $this->participation_user;
    }

    public function setParticipationUser(?int $participation_user): self
    {
        $this->participation_user = $participation_user;

        return $this;
    }

    public function getELike(): ?int
    {
        return $this->e_like;
    }

    public function setELike(?int $e_like): self
    {
        $this->e_like = $e_like;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTypeEvent(): ?string
    {
        return $this->type_event;
    }

    public function setTypeEvent(string $type_event): self
    {
        $this->type_event = $type_event;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
