<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private ?string $nomRecette = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $descriptionRecette = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnailRecette = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $isActive = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;


    #[ORM\Column]
    #[Assert\NotBlank]
    private ?int $Duree = null;

    #[ORM\ManyToOne]
    private ?Pays $pays = null;

    #[ORM\ManyToOne]
    private ?Categorie $categorie = null;

   

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getNomRecette(): ?string
    {
        return $this->nomRecette;
    }

    public function setNomRecette(string $nomRecette): static
    {
        $this->nomRecette = $nomRecette;
        return $this;
    }

    public function getDescriptionRecette(): ?string
    {
        return $this->descriptionRecette;
    }

    public function setDescriptionRecette(string $descriptionRecette): static
    {
        $this->descriptionRecette = $descriptionRecette;
        return $this;
    }

    public function getThumbnailRecette(): ?string
    {
        return $this->thumbnailRecette;
    }

    public function setThumbnailRecette(string $thumbnailRecette): static
    {
        $this->thumbnailRecette = $thumbnailRecette;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;
        return $this;
    }

    

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(int $Duree): static
    {
        $this->Duree = $Duree;
        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;
        return $this;
    }
}
