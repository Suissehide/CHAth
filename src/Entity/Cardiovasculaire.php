<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardiovasculaireRepository")
 */
class Cardiovasculaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tabac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activite_physique;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alimentation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $facteurs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $traitement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTabac(): ?string
    {
        return $this->tabac;
    }

    public function setTabac(?string $tabac): self
    {
        $this->tabac = $tabac;

        return $this;
    }

    public function getActivitePhysique(): ?string
    {
        return $this->activite_physique;
    }

    public function setActivitePhysique(?string $activite_physique): self
    {
        $this->activite_physique = $activite_physique;

        return $this;
    }

    public function getAlimentation(): ?string
    {
        return $this->alimentation;
    }

    public function setAlimentation(?string $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getFacteurs(): ?Pack
    {
        return $this->facteurs;
    }

    public function setFacteurs(?Pack $facteurs): self
    {
        $this->facteurs = $facteurs;

        return $this;
    }

    public function getTraitement(): ?Pack
    {
        return $this->traitement;
    }

    public function setTraitement(?Pack $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }
}
