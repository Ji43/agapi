<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousCategorieProduitRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class SousCategorieProduit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasNatureParfume;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imageCouverture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $courte_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $courte_introduction;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Produit", mappedBy="SousCategorieProduit")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategorieProduit", inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorieProduit;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    /**
     * Initialise le slug
     *
     * @ORM\PrePersist()
     */
    public function initializeSlug()
    {

        $slugify = new Slugify();
        if (empty($this->slug)) {
            $this->slug = $slugify->slugify($this->libelle);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getHasNatureParfume(): ?bool
    {
        return $this->hasNatureParfume;
    }

    public function setHasNatureParfume(bool $hasNatureParfume): self
    {
        $this->hasNatureParfume = $hasNatureParfume;

        return $this;
    }

    public function getImageCouverture(): ?string
    {
        return $this->imageCouverture;
    }

    public function setImageCouverture(string $imageCouverture): self
    {
        $this->imageCouverture = $imageCouverture;

        return $this;
    }

    public function getCourteDescription(): ?string
    {
        return $this->courte_description;
    }

    public function setCourteDescription(string $courte_description): self
    {
        $this->courte_description = $courte_description;

        return $this;
    }

    public function getCourteIntroduction(): ?string
    {
        return $this->courte_introduction;
    }

    public function setCourteIntroduction(string $courte_introduction): self
    {
        $this->courte_introduction = $courte_introduction;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    /**
     * @return array |Produit[]
     */

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setSousCategorieProduit($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->contains($produit)) {
            $this->produits->removeElement($produit);
            // set the owning side to null (unless already changed)
            if ($produit->getSousCategorieProduit() === $this) {
                $produit->setSousCategorieProduit(null);
            }
        }

        return $this;
    }

    public function getCategorieProduit(): ?CategorieProduit
    {
        return $this->categorieProduit;
    }

    public function setCategorieProduit(?CategorieProduit $categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;

        return $this;
    }
}
