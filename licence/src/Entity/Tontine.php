<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TontineRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TontineRepository::class)
 * @ApiResource(
 *      routePrefix="/admin",
 *      attributes={
 *         "security"="is_granted('ROLE_ADMIN')", 
 *         "security_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *     collectionOperations={
 *         "POST"={
 *              "method"="POST",
 *              "path"="admin/tontine",
 *              "route_name"="addTontine"
 *         },
 *         "GET"
 *     },
 *     itemOperations={"PUT", "GET", "DELETE"},
 *     attributes={
 *      "input_formats"={"json"={"application/ld+json", "application/json"}},
 *      "output_formats"={"json"={"application/ld+json", "application/json"}}
 *     },
 *     normalizationContext={"groups"={"Tontine:read"}},
 *     denormalizationContext={"groups"={"Tontine:write"}}
 * )
 */
class Tontine
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     * @Groups({"Tour:read"})
     * @Groups({"Tour:write"})
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     * @Groups({"User:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     */
    private $session;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=Tour::class, mappedBy="tontine",cascade={"persist"})
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     * @Groups({"User:read"})
     * @ApiSubresource()
     */
    private $tour;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     */
    private $dateFin;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="tontine")
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     */
    private $users;

    public function __construct()
    {
        $this->tour = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): self
    {
        $this->session = $session;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    /**
     * @return Collection|Tour[]
     */
    public function getTour(): Collection
    {
        return $this->tour;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tour->contains($tour)) {
            $this->tour[] = $tour;
            $tour->setTontine($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tour->removeElement($tour)) {
            // set the owning side to null (unless already changed)
            if ($tour->getTontine() === $this) {
                $tour->setTontine(null);
            }
        }

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addTontine($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTontine($this);
        }

        return $this;
    }

}
