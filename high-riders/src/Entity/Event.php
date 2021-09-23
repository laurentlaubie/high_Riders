<?php

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"event_list", "event_detail", "spot_list", "spot_detail"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="merci de saisir un titre")
     * @Groups({"event_list", "event_detail","spot_list", "spot_detail"})
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2100)
     * 
     * @Assert\NotBlank(message="merci d'upload une image")
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(message="merci de saisir un nom")
     * @Groups({"event_detail"})
     *
     */
    private $description;

    /**
     * @ORM\Column(type="time", nullable=true)
     * 
     * @Groups({"event_detail"})
     *
     */
    private $opening_hours;

    /**
     * @ORM\Column(type="time", nullable=true)
     * 
     * @Groups({"event_detail"})
     *
     */
    private $closed_hours;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * @Groups({"event_detail"})
     *
     */
    private $difficulty;

    /**
     * @ORM\Column(type="date")
     * 
     * @Assert\NotBlank(message="merci de saisir un nom")
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $date_event;

    /**
     * @ORM\Column(type="string", length=2100, nullable=true)
     * 
     * @Groups({"event_detail"})
     *
     */
    private $link;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"event_detail"})
     *
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Groups({"event_detail"})
     *
     */
    private $accessibility;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $participation_user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $e_like;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50, options={"default" : 1})
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $type_event;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="event")
     * 
     * @Groups({"event_detail"})
     *
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="event")
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Spot::class, inversedBy="event")
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $spot;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="event")
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $departement;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="event")
     * 
     * @Groups({"event_list", "event_detail"})
     *
     */
    private $participations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->participations = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
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

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addEvent($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeEvent($this);
        }

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

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setEvent($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getEvent() === $this) {
                $participation->setEvent(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
