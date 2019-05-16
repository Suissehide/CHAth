<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InformationRepository")
 */
class Information
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_survenue;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $traitement;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $complications;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $CRP;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hemoglobine;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $leucocytes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $PNN;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $plaquettes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $cholesterol;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $LDL_c;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $HDL_c;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $HbA1c;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $creatininemie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSurvenue(): ?\DateTimeInterface
    {
        return $this->date_survenue;
    }

    public function setDateSurvenue(?\DateTimeInterface $date_survenue): self
    {
        $this->date_survenue = $date_survenue;

        return $this;
    }

    public function getType(): ?Pack
    {
        return $this->type;
    }

    public function setType(?Pack $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTraitement(): ?string
    {
        return $this->traitement;
    }

    public function setTraitement(?string $traitement): self
    {
        $this->traitement = $traitement;

        return $this;
    }

    public function getComplications(): ?Pack
    {
        return $this->complications;
    }

    public function setComplications(?Pack $complications): self
    {
        $this->complications = $complications;

        return $this;
    }

    public function getCRP(): ?int
    {
        return $this->CRP;
    }

    public function setCRP(?int $CRP): self
    {
        $this->CRP = $CRP;

        return $this;
    }

    public function getHemoglobine(): ?float
    {
        return $this->hemoglobine;
    }

    public function setHemoglobine(?float $hemoglobine): self
    {
        $this->hemoglobine = $hemoglobine;

        return $this;
    }

    public function getLeucocytes(): ?float
    {
        return $this->leucocytes;
    }

    public function setLeucocytes(?float $leucocytes): self
    {
        $this->leucocytes = $leucocytes;

        return $this;
    }

    public function getPNN(): ?float
    {
        return $this->PNN;
    }

    public function setPNN(?float $PNN): self
    {
        $this->PNN = $PNN;

        return $this;
    }

    public function getPlaquettes(): ?float
    {
        return $this->plaquettes;
    }

    public function setPlaquettes(?float $plaquettes): self
    {
        $this->plaquettes = $plaquettes;

        return $this;
    }

    public function getCholesterol(): ?float
    {
        return $this->cholesterol;
    }

    public function setCholesterol(?float $cholesterol): self
    {
        $this->cholesterol = $cholesterol;

        return $this;
    }

    public function getLDLC(): ?float
    {
        return $this->LDL_c;
    }

    public function setLDLC(?float $LDL_c): self
    {
        $this->LDL_c = $LDL_c;

        return $this;
    }

    public function getHDLC(): ?float
    {
        return $this->HDL_c;
    }

    public function setHDLC(?float $HDL_c): self
    {
        $this->HDL_c = $HDL_c;

        return $this;
    }

    public function getHbA1c(): ?float
    {
        return $this->HbA1c;
    }

    public function setHbA1c(?float $HbA1c): self
    {
        $this->HbA1c = $HbA1c;

        return $this;
    }

    public function getCreatininemie(): ?float
    {
        return $this->creatininemie;
    }

    public function setCreatininemie(?float $creatininemie): self
    {
        $this->creatininemie = $creatininemie;

        return $this;
    }
}
