<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandassocRepository")
 */
class Commandassoc
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Assoc")
     * @ORM\JoinColumn(nullable=false)
     */
    private $assoc;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Command", inversedBy="commandassocs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $command;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }
}
