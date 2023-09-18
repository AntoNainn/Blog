<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $contenu = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'LesArticles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Avis::class)]
    private Collection $AvisArticle;

    #[ORM\ManyToOne(inversedBy: 'UneCategorie')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    public function __construct()
    {
        $this->AvisArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvisArticle(): Collection
    {
        return $this->AvisArticle;
    }

    public function addAvisArticle(Avis $avisArticle): static
    {
        if (!$this->AvisArticle->contains($avisArticle)) {
            $this->AvisArticle->add($avisArticle);
            $avisArticle->setArticle($this);
        }

        return $this;
    }

    public function removeAvisArticle(Avis $avisArticle): static
    {
        if ($this->AvisArticle->removeElement($avisArticle)) {
            // set the owning side to null (unless already changed)
            if ($avisArticle->getArticle() === $this) {
                $avisArticle->setArticle(null);
            }
        }

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
    public function __toString(){
        return $this->titre;
    }
}
