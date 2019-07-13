<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use App\Entity\Command;

class StateCommandEvent extends Event
{
    protected $user;

    public function __construct(User $user)
    {

        $this->user = $user;
    }

    public function getUser():User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
