<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VerificationRepository")
 */
class Verification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Qcm", mappedBy="verification")
     */
    private $inclusion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Qcm", mappedBy="verification")
     */
    private $non_inclusion;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taille;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $poids;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $imc;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $systolique;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $diastolique;

    public function __construct()
    {
        $this->inclusion = new ArrayCollection();
        $this->non_inclusion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getInclusion(): Collection
    {
        return $this->inclusion;
    }

    public function addInclusion(Qcm $inclusion): self
    {
        if (!$this->inclusion->contains($inclusion)) {
            $this->inclusion[] = $inclusion;
            $inclusion->setVerification($this);
        }

        return $this;
    }

    public function removeInclusion(Qcm $inclusion): self
    {
        if ($this->inclusion->contains($inclusion)) {
            $this->inclusion->removeElement($inclusion);
            // set the owning side to null (unless already changed)
            if ($inclusion->getVerification() === $this) {
                $inclusion->setVerification(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getNonInclusion(): Collection
    {
        return $this->non_inclusion;
    }

    public function addNonInclusion(Qcm $nonInclusion): self
    {
        if (!$this->non_inclusion->contains($nonInclusion)) {
            $this->non_inclusion[] = $nonInclusion;
            $nonInclusion->setVerification($this);
        }

        return $this;
    }

    public function removeNonInclusion(Qcm $nonInclusion): self
    {
        if ($this->non_inclusion->contains($nonInclusion)) {
            $this->non_inclusion->removeElement($nonInclusion);
            // set the owning side to null (unless already changed)
            if ($nonInclusion->getVerification() === $this) {
                $nonInclusion->setVerification(null);
            }
        }

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(?int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getImc(): ?float
    {
        return $this->imc;
    }

    public function setImc(?float $imc): self
    {
        $this->imc = $imc;

        return $this;
    }

    public function getSystolique(): ?float
    {
        return $this->systolique;
    }

    public function setSystolique(?float $systolique): self
    {
        $this->systolique = $systolique;

        return $this;
    }

    public function getDiastolique(): ?float
    {
        return $this->diastolique;
    }

    public function setDiastolique(?float $diastolique): self
    {
        $this->diastolique = $diastolique;

        return $this;
    }
}
