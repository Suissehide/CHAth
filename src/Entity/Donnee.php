<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"advancement", "export"})
     */
    private $dateVisite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $recidive;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $dateSurvenue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $dyspnee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $douleur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $tabac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $activite;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $alimentation = [];

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement", "export"})
     * @ORM\JoinTable(name="donnee_qcm_facteurs",
     *      joinColumns={@ORM\JoinColumn(name="facteurs_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $facteurs;

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement", "export"})
     * @ORM\JoinTable(name="donnee_qcm_traitement",
     *      joinColumns={@ORM\JoinColumn(name="traitement_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $traitement;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $crp;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $hemoglobine;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $leucocytes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $pnn;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $plaquettes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $cholesterol;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $ldl;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $hdl;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $hba1c;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $creatininemie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $hematopoiese;


    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $numberOfMutation;

    /**
     * @ORM\ManyToMany(targetEntity=Gene::class, cascade={"persist"})
     * @ORM\OrderBy({"nom" = "ASC"})
     * @Groups({"advancement", "export"})
     */
    private $genes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $carotideCommuneDroite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $carotideCommuneDroiteDone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $carotideCommuneGauche;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $carotideCommuneGaucheDone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $carotideInterneDroite;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $carotideInterneDroiteDone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $carotideInterneGauche;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $carotideInterneGaucheDone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"advancement", "export"})
     */
    private $fraction;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $fractionDone;

    public function __construct()
    {
        $this->facteurs = new ArrayCollection();
        $this->traitement = new ArrayCollection();
        $this->genes = new ArrayCollection();
    }

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

    public function getAlimentation(): ?array
    {
        return $this->alimentation;
    }

    public function setAlimentation(?array $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getFacteurs(): Collection
    {
        return $this->facteurs;
    }

    public function addFacteur(Qcm $facteur): self
    {
        if (!$this->facteurs->contains($facteur)) {
            $this->facteurs[] = $facteur;
        }

        return $this;
    }

    public function removeFacteur(Qcm $facteur): self
    {
        if ($this->facteurs->contains($facteur)) {
            $this->facteurs->removeElement($facteur);
        }

        return $this;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getTraitement(): Collection
    {
        return $this->traitement;
    }

    public function addTraitement(Qcm $traitement): self
    {
        if (!$this->traitement->contains($traitement)) {
            $this->traitement[] = $traitement;
        }

        return $this;
    }

    public function removeTraitement(Qcm $traitement): self
    {
        if ($this->traitement->contains($traitement)) {
            $this->traitement->removeElement($traitement);
        }

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

    public function getCreatininemie(): ?float
    {
        return $this->creatininemie;
    }

    public function setCreatininemie(?float $creatininemie): self
    {
        $this->creatininemie = $creatininemie;

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

    public function getNumberOfMutation(): ?int
    {
        return $this->numberOfMutation;
    }

    public function setNumberOfMutation(?int $numberOfMutation): self
    {
        $this->numberOfMutation = $numberOfMutation;

        return $this;
    }

    /**
     * @return Collection|Gene[]
     */
    public function getGenes(): Collection
    {
        return $this->genes;
    }

    public function addGene(Gene $gene): self
    {
        if (!$this->genes->contains($gene)) {
            $this->genes[] = $gene;
        }

        return $this;
    }

    public function removeGene(Gene $gene): self
    {
        if ($this->genes->contains($gene)) {
            $this->genes->removeElement($gene);
        }

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

    public function getCarotideCommuneDroiteDone(): ?bool
    {
        return $this->carotideCommuneDroiteDone;
    }

    public function setCarotideCommuneDroiteDone(?bool $carotideCommuneDroiteDone): self
    {
        $this->carotideCommuneDroiteDone = $carotideCommuneDroiteDone;

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

    public function getCarotideCommuneGaucheDone(): ?bool
    {
        return $this->carotideCommuneGaucheDone;
    }

    public function setCarotideCommuneGaucheDone(?bool $carotideCommuneGaucheDone): self
    {
        $this->carotideCommuneGaucheDone = $carotideCommuneGaucheDone;

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

    public function getCarotideInterneDroiteDone(): ?bool
    {
        return $this->carotideInterneDroiteDone;
    }

    public function setCarotideInterneDroiteDone(?bool $carotideInterneDroiteDone): self
    {
        $this->carotideInterneDroiteDone = $carotideInterneDroiteDone;

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

    public function getCarotideInterneGaucheDone(): ?bool
    {
        return $this->carotideInterneGaucheDone;
    }

    public function setCarotideInterneGaucheDone(?bool $carotideInterneGaucheDone): self
    {
        $this->carotideInterneGaucheDone = $carotideInterneGaucheDone;

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
    
    public function getFractionDone(): ?bool
    {
        return $this->fractionDone;
    }

    public function setFractionDone(?bool $fractionDone): self
    {
        $this->fractionDone = $fractionDone;

        return $this;
    }
}
