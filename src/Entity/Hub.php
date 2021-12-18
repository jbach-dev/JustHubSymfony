<?php

namespace App\Entity;

use App\Repository\HubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HubRepository::class)
 */
class Hub
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberPlace;

    /**
     * @ORM\OneToMany(targetEntity=Package::class, mappedBy="hub")
     */
    private $packages;

    /**
     * @ORM\OneToMany(targetEntity=Locker::class, mappedBy="hub")
     */
    private $lockers;

    public function __construct()
    {
        $this->packages = new ArrayCollection();
        $this->lockers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getNumberPlace(): ?int
    {
        return $this->numberPlace;
    }

    public function setNumberPlace(int $numberPlace): self
    {
        $this->numberPlace = $numberPlace;

        return $this;
    }

    /**
     * @return Collection|Package[]
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): self
    {
        if (!$this->packages->contains($package)) {
            $this->packages[] = $package;
            $package->setHub($this);
        }

        return $this;
    }

    public function removePackage(Package $package): self
    {
        if ($this->packages->removeElement($package)) {
            // set the owning side to null (unless already changed)
            if ($package->getHub() === $this) {
                $package->setHub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Locker[]
     */
    public function getLockers(): Collection
    {
        return $this->lockers;
    }

    public function addLocker(Locker $locker): self
    {
        if (!$this->lockers->contains($locker)) {
            $this->lockers[] = $locker;
            $locker->setHub($this);
        }

        return $this;
    }

    public function removeLocker(Locker $locker): self
    {
        if ($this->lockers->removeElement($locker)) {
            // set the owning side to null (unless already changed)
            if ($locker->getHub() === $this) {
                $locker->setHub(null);
            }
        }

        return $this;
    }
}
