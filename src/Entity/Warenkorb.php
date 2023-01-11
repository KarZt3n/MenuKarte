<?php

namespace App\Entity;

use App\Repository\WarenkorbRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WarenkorbRepository::class)
 */
class Warenkorb
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
    private $artikelID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $artikelname;

    /**
     * @ORM\Column(type="integer")
     */
    private $anzahl;

    /**
     * @ORM\Column(type="float")
     */
    private $epreis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtikelID(): ?int
    {
        return $this->artikelID;
    }

    public function setArtikelID(int $artikelID): self
    {
        $this->artikelID = $artikelID;

        return $this;
    }

    public function getArtikelname(): ?string
    {
        return $this->artikelname;
    }

    public function setArtikelname(string $artikelname): self
    {
        $this->artikelname = $artikelname;

        return $this;
    }

    public function getAnzahl(): ?int
    {
        return $this->anzahl;
    }

    public function setAnzahl(int $anzahl): self
    {
        $this->anzahl = $anzahl;

        return $this;
    }

    public function getEpreis(): ?float
    {
        return $this->epreis;
    }

    public function setEpreis(float $epreis): self
    {
        $this->epreis = $epreis;

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
}
