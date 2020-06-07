<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @Groups({"advancement"})
     */
    private $dateSurvenue;

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement"})
     * @ORM\JoinTable(name="information_qcm_type",
     *      joinColumns={@ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $type;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"advancement"})
     */
    private $traitementPhaseAigue = [];

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement"})
     * @ORM\JoinTable(name="information_qcm_complications",
     *      joinColumns={@ORM\JoinColumn(name="complications_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $complications;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement"})
     */
    private $crp;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement"})
     */
    private $hemoglobine;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement"})
     */
    private $leucocytes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement"})
     */
    private $PNN;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement"})
     */
    private $plaquettes;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement"})
     */
    private $cholesterol;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement"})
     */
    private $LDLC;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     * @Groups({"advancement"})
     */
    private $HDLC;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement"})
     */
    private $HbA1c;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=1, nullable=true)
     * @Groups({"advancement"})
     */
    private $creatininemie;

    public function __construct()
    {
        $this->complications = new ArrayCollection();
        $this->type = new ArrayCollection();
    }

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

    /**
     * @return Collection|Qcm[]
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(Qcm $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
        }

        return $this;
    }

    public function removeType(Qcm $type): self
    {
        if ($this->type->contains($type)) {
            $this->type->removeElement($type);
        }

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

        /**
     * @return Collection|Qcm[]
     */
    public function getComplications(): Collection
    {
        return $this->complications;
    }

    public function addComplication(Qcm $complication): self
    {
        if (!$this->complications->contains($complication)) {
            $this->complications[] = $complication;
        }

        return $this;
    }

    public function removeComplication(Qcm $complication): self
    {
        if ($this->complications->contains($complication)) {
            $this->complications->removeElement($complication);
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
