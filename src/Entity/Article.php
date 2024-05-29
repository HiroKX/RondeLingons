<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $utitre;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $contenu;

    #[ORM\ManyToOne(targetEntity: Type::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(name: "type_code", referencedColumnName: "code", nullable: false)]
    private Type $type;

    #[ORM\ManyToOne(targetEntity: Archive::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private Archive $annee;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $dateAdd;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $files = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $images = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $imagesGallery = null;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return $this
     */
    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUtitre(): ?string
    {
        return $this->utitre;
    }

    /**
     * @param string $utitre
     * @return $this
     */
    public function setUtitre(string $utitre): self
    {
        $this->utitre = $utitre;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     * @return $this
     */
    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * @return type|null
     */
    public function getType(): ?type
    {
        return $this->type;
    }

    /**
     * @param type|null $type
     * @return $this
     */
    public function setType(?type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return archive|null
     */
    public function getAnnee(): ?archive
    {
        return $this->annee;
    }

    /**
     * @param archive|null $annee
     * @return $this
     */
    public function setAnnee(?archive $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    /**
     * @param \DateTimeInterface $dateAdd
     * @return $this
     */
    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getFiles(): ?array
    {
        return $this->files;
    }

    public function setFiles(?array $files): static
    {
        $this->files = $files;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getImagesGallery(): ?array
    {
        return $this->imagesGallery;
    }

    public function setImagesGallery(?array $imagesGallery): static
    {
        $this->imagesGallery = $imagesGallery;

        return $this;
    }


}
