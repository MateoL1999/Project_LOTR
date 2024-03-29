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
    private $title;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'wiki')]
    private $user;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $url;

    #[ORM\Column(type: 'text', nullable: true)]
    private $content;




    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'wikis')]
    private $category;

    public function __toString() {
        return $this->getTitle();
    }

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

    #[ORM\OneToMany(mappedBy: 'wiki', targetEntity: Comment::class)]
    private $comments;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


    public function __construct()
    {
      $this->category = new ArrayCollection();
      $this->User = new ArrayCollection();
      $this->comments = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }


    public function getUrl(): ?string
    {
        return $this->url;
    }


    /**
     * @return Collection<int, Category>
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
            $category->addWiki($this);
        }

        return $this;
    }

    public function removeCategories(Category $category): self
    {
        if ($this->category->removeElement($category)) {
            $category->removeWiki($this);
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setWiki($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getWiki() === $this) {
                $comment->setWiki(null);
            }
        }

        return $this;
    }

}
