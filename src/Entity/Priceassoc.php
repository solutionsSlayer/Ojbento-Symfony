<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceassocRepository")
 */
class Priceassoc
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pricetype")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Assoc", inversedBy="price")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assoc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?Pricetype
    {
        return $this->type;
    }

    public function setType(?Pricetype $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAssoc(): ?Assoc
    {
        return $this->assoc;
    }

    public function setAssoc(?Assoc $assoc): self
    {
        $this->assoc = $assoc;

        return $this;
    }
    public function __toString()
    {
       return $this->getValue();
    }
}
