<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BusinessHourRepository")
 */
class BusinessHour
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $day;

    /**
     * @ORM\Column(type="time")
     */
    private $openTime;

    /**
     * @ORM\Column(type="time")
     */
    private $closeTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Professional", inversedBy="businessHour", cascade={"persist", "remove"})
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
