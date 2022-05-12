<?php

namespace App\Entity;

use App\Repository\WikiRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WikiRepository::class)]
class Wiki
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Titre;

    #[ORM\Column(type: 'date')]
    private $Date;

    #[ORM\Column(type: 'string', length: 255)]
    private $editeur;

    #[ORM\Column(type: 'string', length: 255)]
    private $contenus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): self
    {
        $this->editeur = $editeur;

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
}
