<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $label;

    #[ORM\ManyToMany(targetEntity: Wiki::class, inversedBy: 'categorie')]
    private $wiki;

    public function __construct()
    {
        $this->wiki = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Wiki>
     */
    public function getWiki(): Collection
    {
        return $this->wiki;
    }

    public function addWiki(Wiki $wiki): self
    {
        if (!$this->wiki->contains($wiki)) {
            $this->wiki[] = $wiki;
        }

        return $this;
    }

    public function removeWiki(Wiki $wiki): self
    {
        $this->wiki->removeElement($wiki);

        return $this;
    }
}
