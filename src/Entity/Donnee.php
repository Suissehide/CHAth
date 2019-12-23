<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonneeRepository")
 */
class Donnee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateVisite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recidive;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSurvenue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dyspnee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $douleur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tabac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activite;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $traitement;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $crp;

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
    private $pnn;

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
    private $ldl;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hdl;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hba1c;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $hematopoiese;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $carotideCommuneDroite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $carotideCommuneGauche;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $carotideInterneDroite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $carotideInterneGauche;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $fraction;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $genes;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pack", cascade={"persist", "remove"})
     */
    private $facteurs;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $alimentation = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(?\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getRecidive(): ?string
    {
        return $this->recidive;
    }

    public function setRecidive(?string $recidive): self
    {
        $this->recidive = $recidive;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDyspnee(): ?int
    {
        return $this->dyspnee;
    }

    public function setDyspnee(?int $dyspnee): self
    {
        $this->dyspnee = $dyspnee;

        return $this;
    }

    public function getDouleur(): ?int
    {
        return $this->douleur;
    }

    public function setDouleur(?int $douleur): self
    {
        $this->douleur = $douleur;

        return $this;
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

    public function getActivite(): ?string
    {
        return $this->activite;
    }

    public function setActivite(?string $activite): self
    {
        $this->activite = $activite;

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

    public function getPnn(): ?float
    {
        return $this->pnn;
    }

    public function setPnn(?float $pnn): self
    {
        $this->pnn = $pnn;

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

    public function getLdl(): ?float
    {
        return $this->ldl;
    }

    public function setLdl(?float $ldl): self
    {
        $this->ldl = $ldl;

        return $this;
    }

    public function getHdl(): ?float
    {
        return $this->hdl;
    }

    public function setHdl(?float $hdl): self
    {
        $this->hdl = $hdl;

        return $this;
    }

    public function getHba1c(): ?float
    {
        return $this->hba1c;
    }

    public function setHba1c(?float $hba1c): self
    {
        $this->hba1c = $hba1c;

        return $this;
    }

    public function getHematopoiese(): ?string
    {
        return $this->hematopoiese;
    }

    public function setHematopoiese(?string $hematopoiese): self
    {
        $this->hematopoiese = $hematopoiese;

        return $this;
    }

    public function getCarotideCommuneDroite(): ?float
    {
        return $this->carotideCommuneDroite;
    }

    public function setCarotideCommuneDroite(?float $carotideCommuneDroite): self
    {
        $this->carotideCommuneDroite = $carotideCommuneDroite;

        return $this;
    }

    public function getCarotideCommuneGauche(): ?float
    {
        return $this->carotideCommuneGauche;
    }

    public function setCarotideCommuneGauche(?float $carotideCommuneGauche): self
    {
        $this->carotideCommuneGauche = $carotideCommuneGauche;

        return $this;
    }

    public function getCarotideInterneDroite(): ?float
    {
        return $this->carotideInterneDroite;
    }

    public function setCarotideInterneDroite(?float $carotideInterneDroite): self
    {
        $this->carotideInterneDroite = $carotideInterneDroite;

        return $this;
    }

    public function getCarotideInterneGauche(): ?float
    {
        return $this->carotideInterneGauche;
    }

    public function setCarotideInterneGauche(?float $carotideInterneGauche): self
    {
        $this->carotideInterneGauche = $carotideInterneGauche;

        return $this;
    }

    public function getFraction(): ?float
    {
        return $this->fraction;
    }

    public function setFraction(?float $fraction): self
    {
        $this->fraction = $fraction;

        return $this;
    }

    public function getGenes(): ?Pack
    {
        return $this->genes;
    }

    public function setGenes(?Pack $genes): self
    {
        $this->genes = $genes;

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

    public function getAlimentation(): ?array
    {
        return $this->alimentation;
    }

    public function setAlimentation(?array $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }
}
