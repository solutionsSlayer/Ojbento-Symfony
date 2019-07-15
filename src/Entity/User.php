<?php
namespace App\Entity;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class User
 * @ORM\Entity
 * @ORM\Table (name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Command", mappedBy="user", orphanRemoval=true)
     */
    private $commands;

    /**
     * @ORM\Column(type="string")
     */
    protected $fname;
    /**
     * @ORM\Column(type="string")
     */
    protected $lname;
    /**
     * @ORM\Column(type="string")
     */
    protected $phone;
    /**
     * @ORM\Column(type="string")
     */
    protected $city;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $apikey;


    public function __construct()
    {
        $this->created_at = new \DateTime('now');
        $this->updated_at = new \DateTime('now');
        parent::__construct();
        $this->commands = new ArrayCollection();
    }

    /**
     * @return Collection|Command[]
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFname(): ?string
    {
        return $this->fname;
    }
    public function setFname(string $fname): self
    {
        $this->fname = $fname;
        return $this;
    }
    public function getLname(): ?string
    {
        return $this->lname;
    }
    public function setLname(string $lname): self
    {
        $this->lname = $lname;
        return $this;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    public function setPhone(string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }
    public function getCity(): ?string
    {
        return $this->city;
    }
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }


    public function addCommand(Command $command): self
    {
        if (!$this->commands->contains($command)) {
            $this->commands[] = $command;
            $command->setUser($this);
        }

        return $this;
    }

    public function removeCommand(Command $command): self
    {
        if ($this->commands->contains($command)) {
            $this->commands->removeElement($command);
            // set the owning side to null (unless already changed)
            if ($command->getUser() === $this) {
                $command->setUser(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getApikey(): ?string
    {
        return $this->apikey;
    }

    public function setApikey(?string $apikey): self
    {
        $this->apikey = $apikey;

        return $this;
    }
}

