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
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Article::class)]
    private Collection $UneCategorie;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->UneCategorie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getUneCategorie(): Collection
    {
        return $this->UneCategorie;
    }

    public function addUneCategorie(Article $uneCategorie): static
    {
        if (!$this->UneCategorie->contains($uneCategorie)) {
            $this->UneCategorie->add($uneCategorie);
            $uneCategorie->setCategorie($this);
        }

        return $this;
    }

    public function removeUneCategorie(Article $uneCategorie): static
    {
        if ($this->UneCategorie->removeElement($uneCategorie)) {
            // set the owning side to null (unless already changed)
            if ($uneCategorie->getCategorie() === $this) {
                $uneCategorie->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
