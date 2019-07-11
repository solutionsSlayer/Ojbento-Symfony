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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandmenu", mappedBy="command", orphanRemoval=true)
     */
    private $commandmenus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Time")
     * @ORM\JoinColumn(nullable=true)
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\State")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    public function __construct()
    {
        $this->commandassocs = new ArrayCollection();
        $this->commandmenus = new ArrayCollection();
        $this->datetime = new \DateTime('now');
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

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }
    /**
     * @return Collection|Commandmenu[]
     */
    public function getCommandmenus(): Collection
    {
        return $this->commandmenus;
    }

    public function addCommandmenu(Commandmenu $commandmenu): self
    {
        if (!$this->commandmenus->contains($commandmenu)) {
            $this->commandmenus[] = $commandmenu;
            $commandmenu->setCommand($this);
        }

        return $this;
    }

    public function removeCommandmenu(Commandmenu $commandmenu): self
    {
        if ($this->commandmenus->contains($commandmenu)) {
            $this->commandmenus->removeElement($commandmenu);
            // set the owning side to null (unless already changed)
            if ($commandmenu->getCommand() === $this) {
                $commandmenu->setCommand(null);
            }
        }

        return $this;
    }

    public function getTime(): ?Time
    {
        return $this->time;
    }

    public function setTime(?Time $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

        return $this;
    }
}
