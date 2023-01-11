<?php

namespace App\Entity;

use App\Repository\GerichtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GerichtRepository::class)
 */
class Gericht
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $beschreibung;

    /**
     * @ORM\Column(type="float")
     */
    private $preis;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bild;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Kategorie", inversedBy="gericht")
     */
    private $kategorie;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hide;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(type="integer")
     */
    private $reihenfolge;

    /**
     * @ORM\ManyToMany(targetEntity=Warenkorb::class, mappedBy="artikelID")
     */
    private $warenkorbs;

    public function __construct()
    {
        $this->warenkorbs = new ArrayCollection();
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

    public function getBeschreibung(): ?string
    {
        return $this->beschreibung;
    }

    public function setBeschreibung(?string $beschreibung): self
    {
        $this->beschreibung = $beschreibung;

        return $this;
    }

    public function getPreis(): ?float
    {
        return $this->preis;
    }

    public function setPreis(float $preis): self
    {
        $this->preis = $preis;

        return $this;
    }

    public function getBild(): ?string
    {
        return $this->bild;
    }

    public function setBild(string $bild): self
    {
        $this->bild = $bild;

        return $this;
    }

    public function getKategorie(): ?Kategorie
    {
        return $this->kategorie;
    }

    public function setKategorie(?Kategorie $kategorie): self
    {
        $this->kategorie = $kategorie;

        return $this;
    }

    public function isHide(): ?bool
    {
        return $this->hide;
    }

    public function setHide(?bool $hide): self
    {
        $this->hide = $hide;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(?bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getReihenfolge(): ?int
    {
        return $this->reihenfolge;
    }

    public function setReihenfolge(int $reihenfolge): self
    {
        $this->reihenfolge = $reihenfolge;

        return $this;
    }

    /**
     * @return Collection<int, Warenkorb>
     */
    public function getWarenkorbs(): Collection
    {
        return $this->warenkorbs;
    }

    public function addWarenkorb(Warenkorb $warenkorb): self
    {
        if (!$this->warenkorbs->contains($warenkorb)) {
            $this->warenkorbs[] = $warenkorb;
            $warenkorb->addArtikelID($this);
        }

        return $this;
    }

    public function removeWarenkorb(Warenkorb $warenkorb): self
    {
        if ($this->warenkorbs->removeElement($warenkorb)) {
            $warenkorb->removeArtikelID($this);
        }

        return $this;
    }
}
