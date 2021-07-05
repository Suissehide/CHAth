<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"export"})
     */
    private $dateSurvenue;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     * @Groups({"export"})
     */
    private $type;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"export"})
     */
    private $traitementPhaseAigue = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     * @Groups({"export"})
     */
    private $complications;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"export"})
     */
    private $crp;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"export"})
     */
    private $hemoglobine;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"export"})
     */
    private $leucocytes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"export"})
     */
    private $PNN;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"export"})
     */
    private $plaquettes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"export"})
     */
    private $cholesterol;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"export"})
     */
    private $LDLC;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"export"})
     */
    private $HDLC;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"export"})
     */
    private $HbA1c;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"export"})
     */
    private $creatininemie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSurvenue(): ?\DateTimeInterface
    {
        return $this->dateSurvenue;
    }

    public function setDateSurvenue(?\DateTimeInterface $dateSurvenue): self
    {
        $this->dateSurvenue = $dateSurvenue;

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

    public function getTraitementPhaseAigue(): ?array
    {
        return $this->traitementPhaseAigue;
    }

    public function setTraitementPhaseAigue(?array $traitementPhaseAigue): self
    {
        $this->traitementPhaseAigue = $traitementPhaseAigue;

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

    public function getCrp(): ?float
    {
        return $this->crp;
    }

    public function setCrp(?float $crp): self
    {
        $this->crp = $crp;

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
        return $this->LDLC;
    }

    public function setLDLC(?float $LDLC): self
    {
        $this->LDLC = $LDLC;

        return $this;
    }

    public function getHDLC(): ?float
    {
        return $this->HDLC;
    }

    public function setHDLC(?float $HDLC): self
    {
        $this->HDLC = $HDLC;

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
