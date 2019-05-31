<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeRepository")
 */
class Time
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
    private $hour_command;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHourCommand(): ?string
    {
        return $this->hour_command;
    }

    public function setHourCommand(string $hour_command): self
    {
        $this->hour_command = $hour_command;

        return $this;
    }

    public function __toString()
    {
        return $this->getHourCommand();
    }
}
