<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * 
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $content;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $rate;

    /**
     * @ORM\Column(type="string", length=2100, nullable=true)
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $image;

    /**
     * @ORM\Column(type="smallint", options={"default" : 1})
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $label_type;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comment")
     * 
     * @Groups({"spot_detail", "event_detail"})
     * 
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Spot::class, inversedBy="comments")
     * 
     * 
     */
    private $spot;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="comments")
     * 
     * 
     */
    private $event;

    /**
     * Si l'on tente de faire un echo sur l'objet Departement, PHP retournera la valeur du nom
     */
    public function __toString()
    {
        return $this->content;
    }

    public function __construct()
    {
        $this->status = 1;
        $this->createdAt = new DateTimeImmutable();
    }
    
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getLabelType(): ?string
    {
        return $this->label_type;
    }

    public function setLabelType(string $label_type): self
    {
        $this->label_type = $label_type;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSpot(): ?Spot
    {
        return $this->spot;
    }

    public function setSpot(?Spot $spot): self
    {
        $this->spot = $spot;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }
}
