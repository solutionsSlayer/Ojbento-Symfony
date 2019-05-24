<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 */
class Command
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandassoc", mappedBy="command", orphanRemoval=true)
     */
    private $commandassocs;

    public function __construct()
    {
        $this->commandassocs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Commandassoc[]
     */
    public function getCommandassocs(): Collection
    {
        return $this->commandassocs;
    }

    public function addCommandassoc(Commandassoc $commandassoc): self
    {
        if (!$this->commandassocs->contains($commandassoc)) {
            $this->commandassocs[] = $commandassoc;
            $commandassoc->setCommand($this);
        }

        return $this;
    }

    public function removeCommandassoc(Commandassoc $commandassoc): self
    {
        if ($this->commandassocs->contains($commandassoc)) {
            $this->commandassocs->removeElement($commandassoc);
            // set the owning side to null (unless already changed)
            if ($commandassoc->getCommand() === $this) {
                $commandassoc->setCommand(null);
            }
        }

        return $this;
    }
}
