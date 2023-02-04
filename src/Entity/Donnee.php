<?php

namespace App\Entity;

use App\Repository\DonneeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DonneeRepository::class)]
class Donnee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?\DateTimeInterface $dateVisite = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $recidive = null;

    #[ORM\Column(type: 'date', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?\DateTimeInterface $dateSurvenue = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $type = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?int $dyspnee = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?int $douleur = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $tabac = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $activite = null;

    #[ORM\Column(type: 'array', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?array $alimentation = [];

    #[ORM\JoinTable(name: 'donnee_qcm_facteurs')]
    #[ORM\JoinColumn(name: 'facteurs_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'qcm_id', referencedColumnName: 'id', onDelete: 'CASCADE', unique: true)]
    #[ORM\ManyToMany(targetEntity: Qcm::class, cascade: ['persist'])]
    #[Groups(['advancement', 'export'])]
    private Collection|array $facteurs;

    #[ORM\JoinTable(name: 'donnee_qcm_traitement')]
    #[ORM\JoinColumn(name: 'traitement_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\InverseJoinColumn(name: 'qcm_id', referencedColumnName: 'id', onDelete: 'CASCADE', unique: true)]
    #[ORM\ManyToMany(targetEntity: Qcm::class, cascade: ['persist'])]
    #[Groups(['advancement', 'export'])]
    private Collection|array $traitement;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $crp = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 1, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $hemoglobine = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $leucocytes = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $pnn = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 1, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $plaquettes = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $cholesterol = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $ldl = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $hdl = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 1, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $hba1c = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $IL1B = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $IL6 = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $IL10 = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $IL18 = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $TNFa = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $creatininemie = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $hematopoiese = null;


    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?int $numberOfMutation = null;

    #[ORM\ManyToMany(targetEntity: Gene::class, cascade: ['persist'])]
    #[ORM\OrderBy(['nom' => 'ASC'])]
    #[Groups(['advancement', 'export'])]
    private Collection|array $genes;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $carotideCommuneDroite = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $carotideCommuneDroiteDone = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $carotideCommuneGauche = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $carotideCommuneGaucheDone = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $carotideInterneDroite = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $carotideInterneDroiteDone = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $carotideInterneGauche = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $carotideInterneGaucheDone = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?float $fraction = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $fractionDone = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $stenoses = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['advancement', 'export'])]
    private ?string $ips = null;

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

    public function getIL1B(): ?string
    {
        return $this->IL1B;
    }

    public function setIL1B(?string $IL1B): self
    {
        $this->IL1B = $IL1B;

        return $this;
    }

    public function getIL6(): ?string
    {
        return $this->IL6;
    }

    public function setIL6(?string $IL6): self
    {
        $this->IL6 = $IL6;

        return $this;
    }

    public function getIL10(): ?string
    {
        return $this->IL10;
    }

    public function setIL10(?string $IL10): self
    {
        $this->IL10 = $IL10;

        return $this;
    }

    public function getIL18(): ?string
    {
        return $this->IL18;
    }

    public function setIL18(?string $IL18): self
    {
        $this->IL18 = $IL18;

        return $this;
    }

    public function getTNFa(): ?string
    {
        return $this->TNFa;
    }

    public function setTNFa(?string $TNFa): self
    {
        $this->TNFa = $TNFa;

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
    
    public function getStenoses(): ?string
    {
        return $this->stenoses;
    }

    public function setStenoses(?string $stenoses): self
    {
        $this->stenoses = $stenoses;

        return $this;
    }

    public function getIps(): ?string
    {
        return $this->ips;
    }

    public function setIps(?string $ips): self
    {
        $this->ips = $ips;

        return $this;
    }
}
