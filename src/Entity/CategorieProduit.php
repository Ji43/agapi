<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieProduitRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CategorieProduit
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageCouverture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $courte_introduction;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $courte_description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SousCategorieProduit", mappedBy="categorieProduit")
     */
    private $sousCategories;

    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
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

    public function hasSubCategories() {

        if(count($this->getSousCategories()) > 0)
            return true;

    return false;
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

    public function getImageCouverture(): ?string
    {
        return $this->imageCouverture;
    }

    public function setImageCouverture(?string $imageCouverture): self
    {
        $this->imageCouverture = $imageCouverture;

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

    public function getCourteDescription(): ?string
    {
        return $this->courte_description;
    }

    public function setCourteDescription(string $courte_description): self
    {
        $this->courte_description = $courte_description;

        return $this;
    }

    /**
     * @return Collection|SousCategorieProduit[]
     */
    public function getSousCategories(): Collection
    {
        return $this->sousCategories;
    }

    public function addSousCategory(SousCategorieProduit $sousCategory): self
    {
        if (!$this->sousCategories->contains($sousCategory)) {
            $this->sousCategories[] = $sousCategory;
            $sousCategory->setCategorieProduit($this);
        }

        return $this;
    }

    public function removeSousCategory(SousCategorieProduit $sousCategory): self
    {
        if ($this->sousCategories->contains($sousCategory)) {
            $this->sousCategories->removeElement($sousCategory);
            // set the owning side to null (unless already changed)
            if ($sousCategory->getCategorieProduit() === $this) {
                $sousCategory->setCategorieProduit(null);
            }
        }

        return $this;
    }
}
