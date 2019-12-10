<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $slogan;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $intervalTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $area;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="service")
     */
    private $prices;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professional", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $professional;

    /**
     * @ORM\ManyToMany(targetEntity="Customer", inversedBy="services")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceType", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceType;

    public function __construct()
    {
        $this->prices = new ArrayCollection();
        $this->member = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(?string $slogan): self
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIntervalTime()
    {
        return $this->intervalTime;
    }

    public function setIntervalTime($intervalTime): self
    {
        $this->intervalTime = $intervalTime;

        return $this;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setService($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getService() === $this) {
                $price->setService(null);
            }
        }

        return $this;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(?Professional $professional): self
    {
        $this->professional = $professional;

        return $this;
    }

    /**
     * @return Collection|Customer[]
     */
    public function getMember(): Collection
    {
        return $this->member;
    }

    public function addMember(Customer $member): self
    {
        if (!$this->member->contains($member)) {
            $this->member[] = $member;
        }

        return $this;
    }

    public function removeMember(Customer $member): self
    {
        if ($this->member->contains($member)) {
            $this->member->removeElement($member);
        }

        return $this;
    }

    public function getServiceType(): ?ServiceType
    {
        return $this->serviceType;
    }

    public function setServiceType(?ServiceType $serviceType): self
    {
        $this->serviceType = $serviceType;

        return $this;
    }
}
