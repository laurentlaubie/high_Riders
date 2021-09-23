<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"show_user", "spot_list", "spot_detail", "event_list", "event_detail"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Groups({"show_user", "spot_list", "spot_detail", "event_list", "event_detail"})
     * 
     */
    private $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="categories")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Spot::class, mappedBy="categories")
     * 
     */
    private $spot;

    /**
     * @ORM\ManyToMany(targetEntity=Event::class, mappedBy="categories")
     */
    private $event;

    /**
     * Si l'on tente de faire un echo sur l'objet Category, PHP retournera la valeur du nom
     */
    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->spot = new ArrayCollection();
        $this->event = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Spot[]
     */
    public function getSpot(): Collection
    {
        return $this->spot;
    }

    public function addSpot(Spot $spot): self
    {
        if (!$this->spot->contains($spot)) {
            $this->spot[] = $spot;
        }

        return $this;
    }

    public function removeSpot(Spot $spot): self
    {
        $this->spot->removeElement($spot);

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
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->event->removeElement($event);

        return $this;
    }
}
