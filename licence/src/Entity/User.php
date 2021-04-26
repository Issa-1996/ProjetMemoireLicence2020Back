<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "gerant" = "Gerant", "tresorier" = "Tresorier"})
 * @ApiResource(
 *      routePrefix="/admin",
 *      attributes={
 *         "security"="is_granted('ROLE_ADMIN')", 
 *         "security_message"="Vous n'avez pas access à cette Ressource",
 *     },
 *     collectionOperations={"POST","GET"},
 *     itemOperations={"PUT"={
 *          "deserialize"=false,
 *             "validation_groups"={"Default", "media_object_create"},
 *             "swagger_context"={
 *                 "consumes"={
 *                     "multipart/form-data",
 *                 },
 *                 "parameters"={
 *                     {
 *                         "in"="formData",
 *                         "name"="file",
 *                         "type"="file",
 *                         "description"="The file to upload",
 *                     },
 *                 },
 *             },
 * }, "GET", "DELETE"},
 *     normalizationContext={"groups"={"User:read"}},
 *     denormalizationContext={"groups"={"User:write"}},
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"User:read"})
     * @Groups({"Epargne:read"})
     * @Groups({"Tontine:read"})
     * @Groups({"Tour:read"})
     * @Groups({"Profil:read"})
     * @Groups({"User:read"})
     * @Groups({"Gerant:read"})
     * @Groups({"Tresorier:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true) 
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"User:write"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:write"})

     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"User:read"})
     * @Groups({"Gerant:read"})
     * @Groups({"Tresorier:read"})
     */
    private $archivage=false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $Genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"Gerant:read"})
     * @Groups({"Tresorier:read"})
     */
    private $status="actif";

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     * @Assert\NotBlank(message="Le CNI est obligatoire")
     */
    private $cni;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})

     */
    private $adresse;

    /**
     * @ORM\Column(type="blob")
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     * @Groups({"Tontine:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     * @Groups({"Tontine:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users",cascade={"persist"})
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     * @Groups({"Gerant:read"})
     * @Groups({"Gerant:write"})
     * @Groups({"Tresorier:read"})
     * @Groups({"Tresorier:write"})
     */
    private $profil;

    /**
     * @ORM\ManyToMany(targetEntity=Tontine::class, inversedBy="users")
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     */
    private $tontine;

    /**
     * @ORM\ManyToMany(targetEntity=Tour::class, inversedBy="users")
     * @Groups({"User:read"})
     * @Groups({"User:write"})
     */
    private $tour;

    public function __construct()
    {
        $this->tontine = new ArrayCollection();
        $this->tour = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(string $Genre): self
    {
        $this->Genre = $Genre;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCni(): ?string
    {
        return $this->cni;
    }

    public function setCni(string $cni): self
    {
        $this->cni = $cni;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAvatar()
    {
        return base64_encode(stream_get_contents($this->avatar));
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection|Tontine[]
     */
    public function getTontine(): Collection
    {
        return $this->tontine;
    }

    public function addTontine(Tontine $tontine): self
    {
        if (!$this->tontine->contains($tontine)) {
            $this->tontine[] = $tontine;
        }

        return $this;
    }

    public function removeTontine(Tontine $tontine): self
    {
        $this->tontine->removeElement($tontine);

        return $this;
    }

    
    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

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
        }

        return $this;
    }

    public function removeTour(Tour $tour): self
    {
        $this->tour->removeElement($tour);

        return $this;
    }


}
