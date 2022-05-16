<?php

namespace App\Entity;

use App\Repository\WikiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: WikiRepository::class)]
/**
 * @Vich\Uploadable
 */
class Wiki
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'wiki')]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $contenus;

    #[ORM\ManyToMany(targetEntity: Categorie::class, mappedBy: 'wiki')]
    private $categorie;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="wiki_cover", fileNameProperty="imageName")
     *
     * @var File|null
     */
    private $imageFile;


    #[ORM\Column(type:"string")]
    private $imageName;


    #[ORM\Column(type:"datetime", nullable: true)]
    private $updatedAt;


    public function __construct()
    {
      $this->categorie = new ArrayCollection();
      $this->User = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    public function getContenus(): ?string
    {
        return $this->contenus;
    }

    public function setContenus(string $contenus): self
    {
        $this->contenus = $contenus;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
            $categorie->addWiki($this);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categorie->removeElement($categorie)) {
            $categorie->removeWiki($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

}
