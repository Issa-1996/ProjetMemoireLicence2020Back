<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EpargneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=EpargneRepository::class)
 * @ApiResource(
 *      routePrefix="/admin",
 *     collectionOperations={"post"={
 *              "method":"POST",
 *              "path":"/api/admin/epargnes"
 *          },"GET"={
 *              "method":"GET",
 *              "path":"/admin/epargne"
 *          }
 *      },
 *     itemOperations={"PUT", "GET", "DELETE"},
 *     normalizationContext={"groups"={"Epargne:read"}},
 *     denormalizationContext={"groups"={"Epargne:write"}}
 * )
 */
class Epargne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     * @Groups({"Tour:read"})
     * @Groups({"Tour:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     *  @Groups({"User:read"})
     * @Groups({"Tour:read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     * @Groups({"Tour:read"})
     */
    private $interet;

    /**
     * @ORM\Column(type="date")
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     * @Groups({"User:read"})
     * @Groups({"Tour:read"})
     */
    private $dateEpargne;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     */
    private $archivage;

    /**
     * @ORM\ManyToMany(targetEntity=Tour::class, mappedBy="epargnes",cascade={"persist"})
     * @Groups({"Epargne:read"})
     * @Groups({"Epargne:write"})
     */
    private $tours;

    
    public function __construct()
    {
        $this->tours = new ArrayCollection();
    }

        
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getInteret(): ?string
    {
        return $this->interet;
    }

    public function setInteret(string $interet): self
    {
        $this->interet = $interet;

        return $this;
    }

    public function getDateEpargne(): ?\DateTimeInterface
    {
        return $this->dateEpargne;
    }

    public function setDateEpargne(\DateTimeInterface $dateEpargne): self
    {
        $this->dateEpargne = $dateEpargne;

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
    public function getTours(): Collection
    {
        return $this->tours;
    }

    public function addTour(Tour $tour): self
    {
        if (!$this->tours->contains($tour)) {
            $this->tours[] = $tour;
            $tour->addEpargne($this);
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        if ($this->tours->removeElement($tour)) {
            $tour->removeEpargne($this);
        }

        return $this;
    }

}
