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

    #[ORM\ManyToMany(targetEntity: Wiki::class, mappedBy: 'categories')]
    private $wikis;


    public function __toString()
    {
       return $this->getLabel();
    }

    public function __construct()
    {
        $this->wikis = new ArrayCollection();
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
    public function getWikis(): Collection
    {
        return $this->wikis;
    }

    /**
     * @param ArrayCollection $wikis
     */
    public function setWikis(ArrayCollection $wikis): void
    {
        $this->wikis = $wikis;
    }


    public function addWiki(Wiki $wikis): self
    {
        if (!$this->wikis->contains($wikis)) {
            $this->wikis[] = $wikis;
        }

        return $this;
    }

    public function removeWiki(Wiki $wikis): self
    {
        $this->wikis->removeElement($wikis);

        return $this;
    }
}
