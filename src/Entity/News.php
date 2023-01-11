<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 */
class News
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $teaser;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $bodytext;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $modifyAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hide;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEvent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dailyEvent;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $eventStart;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $eventEnde;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bild;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $bilder = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subtitle;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getTeaser(): ?string
    {
        return $this->teaser;
    }

    public function setTeaser(?string $teaser): self
    {
        $this->teaser = $teaser;

        return $this;
    }

    public function getBodytext(): ?string
    {
        return $this->bodytext;
    }

    public function setBodytext(?string $bodytext): self
    {
        $this->bodytext = $bodytext;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        if (!$createAt){
            $createAt = new DateTimeImmutable('now');
        }
        $this->createAt = $createAt;

        return $this;
    }

    public function getModifyAt(): ?\DateTimeImmutable
    {
        return $this->modifyAt;
    }

    public function setModifyAt(?\DateTimeImmutable $modifyAt): self
    {
        $this->modifyAt = $modifyAt;

        return $this;
    }

    public function isHide(): ?bool
    {
        return $this->hide;
    }

    public function setHide(bool $hide): self
    {
        $this->hide = $hide;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function isIsEvent(): ?bool
    {
        return $this->isEvent;
    }

    public function setIsEvent(bool $isEvent): self
    {
        $this->isEvent = $isEvent;

        return $this;
    }

    public function isDailyEvent(): ?bool
    {
        return $this->dailyEvent;
    }

    public function setDailyEvent(bool $dailyEvent): self
    {
        $this->dailyEvent = $dailyEvent;

        return $this;
    }

    public function getEventStart(): ?\DateTimeImmutable
    {
        return $this->eventStart;
    }

    public function setEventStart(?\DateTimeImmutable $eventStart): self
    {
        $this->eventStart = $eventStart;

        return $this;
    }

    public function getEventEnde(): ?\DateTimeImmutable
    {
        return $this->eventEnde;
    }

    public function setEventEnde(?\DateTimeImmutable $eventEnde): self
    {
        $this->eventEnde = $eventEnde;

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

    public function getBilder(): ?array
    {
        return $this->bilder;
    }

    public function setBilder(?array $bilder): self
    {
        $this->bilder = $bilder;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }
}
