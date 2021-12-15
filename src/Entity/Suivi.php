<?php

namespace App\Entity;

use App\Repository\SuiviRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SuiviRepository::class)
 */
class Suivi
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $event;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $eventDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $cause;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $aucunEvenement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?string
    {
        return $this->event;
    }

    public function setEvent(?string $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(?\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(?string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    public function getAucunEvenement(): ?bool
    {
        return $this->aucunEvenement;
    }

    public function setAucunEvenement(?bool $aucunEvenement): self
    {
        $this->aucunEvenement = $aucunEvenement;

        return $this;
    }
}
