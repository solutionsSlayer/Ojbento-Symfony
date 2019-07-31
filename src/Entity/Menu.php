<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use function PHPSTORM_META\type;


/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
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
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMidi;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Pricemenu", cascade={"all"}, mappedBy="menu", orphanRemoval=true)
     */
    private $prices;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Assoc", cascade={"all"}, inversedBy="menus", orphanRemoval=true)
     */
    private $assocs;

    

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->assocs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsMidi(): ?bool
    {
        return $this->isMidi;
    }

    public function setIsMidi(bool $isMidi): self
    {
        $this->isMidi = $isMidi;

        return $this;
    }

    /**
     * @return Collection|Pricemenu[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Pricemenu $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setMenu($this);
        }

        return $this;
    }

    public function removePrice(Pricemenu $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getMenu() === $this) {
                $price->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Assoc[]
     */
    public function getAssocs(): Collection
    {
        return $this->assocs;
    }

    public function addAssoc(Assoc $assoc): self
    {
        if (!$this->assocs->contains($assoc)) {
            $this->assocs[] = $assoc;
            $assoc->addMenu($this);
        }

        return $this;
    }

    public function removeAssoc(Assoc $assoc): self
    {
        if ($this->assocs->contains($assoc)) {
            $this->assocs->removeElement($assoc);
            $assoc->removeMenu($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
