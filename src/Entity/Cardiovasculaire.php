<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @Groups({"advancement"})
     */
    private $tabac;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advancement"})
     */
    private $activitePhysique;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @Groups({"advancement"})
     */
    private $alimentation = [];

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement"})
     * @ORM\JoinTable(name="cardiovasculaire_qcm_facteurs",
     *      joinColumns={@ORM\JoinColumn(name="facteurs_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $facteurs;

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement"})
     * @ORM\JoinTable(name="cardiovasculaire_qcm_traitement",
     *      joinColumns={@ORM\JoinColumn(name="traitement_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $traitement;

    public function __construct()
    {
        $this->facteurs = new ArrayCollection();
        $this->traitement = new ArrayCollection();
    }

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
        return $this->activitePhysique;
    }

    public function setActivitePhysique(?string $activitePhysique): self
    {
        $this->activitePhysique = $activitePhysique;

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
}
