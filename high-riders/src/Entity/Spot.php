<?php

namespace App\Entity;

use App\Repository\SpotRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpotRepository::class)
 */
class Spot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $openingHours;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $closed_hours;

    /**
     * @ORM\Column(type="dateinterval", nullable=true)
     */
    private $saison_date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numbers_users;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $average_rating;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $difficulty;

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
    private $s_like;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $d_positif;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $d_negatif;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $track_number;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type_spot;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

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

    public function getOpeningHours(): ?\DateTimeInterface
    {
        return $this->openingHours;
    }

    public function setOpeningHours(?\DateTimeInterface $openingHours): self
    {
        $this->openingHours = $openingHours;

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

    public function getSaisonDate(): ?\DateInterval
    {
        return $this->saison_date;
    }

    public function setSaisonDate(?\DateInterval $saison_date): self
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
}
