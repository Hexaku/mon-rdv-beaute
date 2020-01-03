<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfessionalRepository")
 * @Vich\Uploadable()
 */
class Professional
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
    private $filename;

    /**
     * @Vich\UploadableField(mapping="professionals_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $place;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="professional", orphanRemoval=true)
     */
    private $services;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\BusinessHour",
     *     mappedBy="professional",
     *     orphanRemoval=true,
     *     cascade={"persist"})
     */
    private $businessHour;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadedAt;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->businessHour = new ArrayCollection();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

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

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setProfessional($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param string|null $filename
     * @return Professional
     */
    public function setFilename(?string $filename): Professional
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return Professional
     */
    public function setImageFile(?File $imageFile): Professional
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeInterface $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;
        if ($this->imageFile instanceof UploadedFile) {
            $this->uploadedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return Collection|BusinessHour[]
     */
    public function getBusinessHour(): Collection
    {
        return $this->businessHour;
    }

    public function addBusinessHour(BusinessHour $businessHour): self
    {
        if (!$this->businessHour->contains($businessHour)) {
            $this->businessHour[] = $businessHour;
            $businessHour->setProfessional($this);
        }

        return $this;
    }

    public function removeBusinessHour(BusinessHour $businessHour): self
    {
        if ($this->businessHour->contains($businessHour)) {
            $this->businessHour->removeElement($businessHour);
        }

        return $this;
    }
}
