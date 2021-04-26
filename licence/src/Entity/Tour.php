<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TourRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      routePrefix="/admin",
 *      attributes={
 *         "security"="is_granted('ROLE_ADMIN')", 
 *         "security_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *     collectionOperations={"POST","GET"},
 *     itemOperations={"PUT", "GET", "DELETE"},
 *     normalizationContext={"groups"={"Tour:read"}},
 *     denormalizationContext={"groups"={"Tour:write"}}
 * )
 * @ORM\Entity(repositoryClass=TourRepository::class)
 */
class Tour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Tour:read"})
     * @Groups({"Tour:write"})
     * @Groups({"Tontine:read"})
     * @Groups({"Tontine:write"})
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tontine::class, inversedBy="tour",cascade={"persist"})
     *  @Groups({"Epargne:read"})
     */
    private $tontine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *  @Groups({"Tour:read"})
     *  @Groups({"Tour:write"})
     *  @Groups({"Tontine:read"})
     *  @Groups({"Epargne:read"})
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity=Epargne::class, inversedBy="tours")
     *  @Groups({"Tour:read"})
     * @Groups({"Tour:write"})
     */
    private $epargnes;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="tour")
     * @Groups({"Tour:read"})
     * @Groups({"Tour:write"})
     *  @Groups({"Epargne:read"})
     */
    private $users;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    public function __construct()
    {
        $this->epargnes = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTontine(): ?Tontine
    {
        return $this->tontine;
    }

    public function setTontine(?Tontine $tontine): self
    {
        $this->tontine = $tontine;

        return $this;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Epargne[]
     */
    public function getEpargnes(): Collection
    {
        return $this->epargnes;
    }

    public function addEpargne(Epargne $epargne): self
    {
        if (!$this->epargnes->contains($epargne)) {
            $this->epargnes[] = $epargne;
        }

        return $this;
    }

    public function removeEpargne(Epargne $epargne): self
    {
        $this->epargnes->removeElement($epargne);

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
            $user->addTour($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTour($this);
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

}
