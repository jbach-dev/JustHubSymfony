<?php

namespace App\Entity;

use App\Repository\LockerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LockerRepository::class)
 */
class Locker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberLocker;

    /**
     * @ORM\ManyToOne(targetEntity=Hub::class, inversedBy="lockers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hub;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNumberLocker(): ?int
    {
        return $this->numberLocker;
    }

    public function setNumberLocker(int $numberLocker): self
    {
        $this->numberLocker = $numberLocker;

        return $this;
    }

    public function getHub(): ?Hub
    {
        return $this->hub;
    }

    public function setHub(?Hub $hub): self
    {
        $this->hub = $hub;

        return $this;
    }
}
