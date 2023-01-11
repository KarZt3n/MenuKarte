<?php

namespace App\Entity;

use App\Repository\KategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=KategorieRepository::class)
 */
class Kategorie
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
     * @ORM\OneToMany(targetEntity="App\Entity\Gericht", mappedBy="kategorie")
     */
    private $gericht;

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

    public function __construct()
    {
        $this->gericht = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $Name): self
    {
        $this->name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Gericht>
     */
    public function getGericht(): Collection
    {
        return $this->gericht;
    }

    public function addGericht(Gericht $gericht): self
    {
        if (!$this->gericht->contains($gericht)) {
            $this->gericht[] = $gericht;
            $gericht->setKategorie($this);
        }

        return $this;
    }

    public function removeGericht(Gericht $gericht): self
    {
        if ($this->gericht->removeElement($gericht)) {
            // set the owning side to null (unless already changed)
            if ($gericht->getKategorie() === $this) {
                $gericht->setKategorie(null);
            }
        }

        return $this;
    }


    public function __toString(){
        return $this->name;
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

    public function setReihenfolge(?int $reihenfolge): self
    {
        $this->reihenfolge = $reihenfolge;

        return $this;
    }
}
