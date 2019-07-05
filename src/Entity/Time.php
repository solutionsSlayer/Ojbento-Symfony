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

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="boolean")
     */
    private $midi;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getMidi(): ?bool
    {
        return $this->midi;
    }

    public function setMidi(bool $midi): self
    {
        $this->midi = $midi;

        return $this;
    }

}
