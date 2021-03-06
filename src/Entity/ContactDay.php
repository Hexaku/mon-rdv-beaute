<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactDayRepository")
 */

//Entity : shows contact details use to give info about special day for people interested into this
class ContactDay
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champ ne peut pas être vide")
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email(message="Cette adresse mail n'est pas valide")
     * @Assert\Length(max="255")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Assert\Regex(pattern="/^[0-9]*$/", message="Le numéro de téléphone ne doit contenir que des chiffres")
     * @Assert\Length(
     *     min="10",
     *     max="10",
     *     minMessage="Le numéro de téléphone doit être composé de 10 chiffres",
     *     maxMessage="Le numéro de téléphone doit être composé de 10 chiffres"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
