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
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Assert\NotBlank
     */
    private $filename;

    /**
     * @Vich\UploadableField(mapping="professionals_image", fileNameProperty="filename")
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(max="100")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     * @Assert\Length(max="255")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     */
    private $place;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Le numéro de téléphone ne doit contenir que des chiffres")
     * @Assert\Length(
     *     min=10,
     *     max=10,
     *     minMessage="Le numéro de téléphone doit être composé de 10 chiffres",
     *     maxMessage="Le numéro de téléphone doit être composé de 10 chiffres"
     * )
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="professional")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="professional")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"filter"})
     */
    private $city;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->businessHour = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->articles = new ArrayCollection();
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): Professional
    {
        $this->filename = $filename;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new DateTime('now');
        }
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

    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setProfessional($this);
        }
        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getProfessional() === $this) {
                $booking->setProfessional(null);
            }
        }
        return $this;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setProfessional($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getProfessional() === $this) {
                $article->setProfessional(null);
            }
        }

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
