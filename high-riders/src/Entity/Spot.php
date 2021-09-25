<?php

namespace App\Entity;

use App\Repository\SpotRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=SpotRepository::class)
 */
class Spot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"spot_list", "spot_detail", "event_detail", "api_home"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * 
     * @Assert\NotBlank(message="merci de saisir un nom")
     * @Groups({"spot_list", "spot_detail", "api_home"})
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=2100)
     * 
     * @Assert\NotBlank(message="merci d'upload une image")
     * @Groups({"spot_list", "spot_detail", "event_detail", "api_home"})
     * 
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank(message="merci de saisir un nom")
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank(message="merci de saisir une ville")
     * @Groups({"spot_list", "spot_detail", "api_home"})
     * 
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $openingHours;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $closed_hours;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * 
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $saison_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * 
     * @Groups({"spot_detail", "api_home"})
     * 
     */
    private $numbers_users;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * 
     * @Groups({"spot_list", "spot_detail", "api_home"})
     * 
     */
    private $average_rating;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $difficulty;

    /**
     * @ORM\Column(type="string", length=2100, nullable=true)
     * 
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $link;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $price;

    /**
     * @ORM\Column(type="text", nullable=true)
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $accessibility;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"spot_list", "spot_detail", "api_home"})
     * 
     */
    private $s_like;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $d_positif;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $d_negatif;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $track_number;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Groups({"spot_detail", "api_home"})
     * 
     */
    private $type_spot;

    /**
     * @ORM\Column(type="smallint", options={"default" : 1})
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     * 
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     * 
     * @Groups({"spot_list", "spot_detail", "api_home"})
     * 
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="spot")
     * 
     * @Groups({"spot_detail"})
     * 
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="spot")
     *
     * @Groups({"spot_list", "spot_detail", "api_home"})
     * 
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="spot")
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="spot")
     * 
     * @Groups({"spot_list", "spot_detail"})
     * 
     */
    private $departement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->event = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->status = 1;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLongitude(): ?int
    {
        return $this->longitude;
    }

    public function setLongitude(?int $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?int
    {
        return $this->latitude;
    }

    public function setLatitude(?int $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->openingHours;
    }

    public function setOpeningHours(?string $openingHours): self
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    public function getClosedHours(): ?string
    {
        return $this->closed_hours;
    }

    public function setClosedHours(?string $closed_hours): self
    {
        $this->closed_hours = $closed_hours;

        return $this;
    }

    public function getSaisonDate(): ?string
    {
        return $this->saison_date;
    }

    public function setSaisonDate(?string $saison_date): self
    {
        $this->saison_date = $saison_date;

        return $this;
    }

    public function getNumbersUsers(): ?int
    {
        return $this->numbers_users;
    }

    public function setNumbersUsers(?int $numbers_users): self
    {
        $this->numbers_users = $numbers_users;

        return $this;
    }

    public function getAverageRating(): ?int
    {
        return $this->average_rating;
    }

    public function setAverageRating(?int $average_rating): self
    {
        $this->average_rating = $average_rating;

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

    public function getSLike(): ?int
    {
        return $this->s_like;
    }

    public function setSLike(?int $s_like): self
    {
        $this->s_like = $s_like;

        return $this;
    }

    public function getDPositif(): ?int
    {
        return $this->d_positif;
    }

    public function setDPositif(?int $d_positif): self
    {
        $this->d_positif = $d_positif;

        return $this;
    }

    public function getDNegatif(): ?int
    {
        return $this->d_negatif;
    }

    public function setDNegatif(?int $d_negatif): self
    {
        $this->d_negatif = $d_negatif;

        return $this;
    }

    public function getTrackNumber(): ?int
    {
        return $this->track_number;
    }

    public function setTrackNumber(?int $track_number): self
    {
        $this->track_number = $track_number;

        return $this;
    }

    public function getTypeSpot(): ?string
    {
        return $this->type_spot;
    }

    public function setTypeSpot(string $type_spot): self
    {
        $this->type_spot = $type_spot;

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
            $comment->setSpot($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getSpot() === $this) {
                $comment->setSpot(null);
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
            $category->addSpot($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeSpot($this);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event[] = $event;
            $event->setSpot($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->event->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getSpot() === $this) {
                $event->setSpot(null);
            }
        }

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
