<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BusinessHourRepository")
 */
class BusinessHour
{
    const DAYS = [
        1 => "Lundi",
        2 => "Mardi",
        3 => "Mercredi",
        4 => "Jeudi",
        5 => "Vendredi",
        6 => "Samedi",
        7 => "Dimanche"
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"calendar"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     * @Assert\Range(min="1", max="7")
     * @Assert\NotBlank()
     * @Groups({"calendar"})
     */
    private $day;

    /**
     * @ORM\Column(type="time")
     * @Assert\Time
     * @Assert\NotBlank()
     * @Groups({"calendar"})
     */
    private $openTime;

    /**
     * @ORM\Column(type="time")
     * @Assert\Time
     * @Assert\NotBlank()
     * @Groups({"calendar"})
     */
    private $closeTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professional", inversedBy="businessHour")
     * @ORM\JoinColumn(nullable=true)
     */
    private $professional;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getDayName(): string
    {
        return self::DAYS[$this->day];
    }

    public function getOpenTime()
    {
        return $this->openTime;
    }

    public function setOpenTime($openTime): self
    {
        $this->openTime = $openTime;

        return $this;
    }

    public function getCloseTime()
    {
        return $this->closeTime;
    }

    public function setCloseTime($closeTime): self
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(Professional $professional): self
    {
        $this->professional = $professional;

        return $this;
    }
}
