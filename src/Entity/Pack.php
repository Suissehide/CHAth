<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PackRepository")
 */
class Pack
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Qcm", mappedBy="pack", cascade={"persist", "remove"})
     * @Groups({"export"})
     */
    private $qcm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gene", mappedBy="pack", cascade={"persist", "remove"})
     * @Groups({"export"})
     */
    private $genes;

    public function __construct()
    {
        $this->qcm = new ArrayCollection();
        $this->genes = new ArrayCollection();
    } 

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getQcm(): Collection
    {
        return $this->qcm;
    }

    public function addQcm(Qcm $qcm): self
    {
        if (!$this->qcm->contains($qcm)) {
            $this->qcm[] = $qcm;
            $qcm->setPack($this);
        }

        return $this;
    }

    public function removeQcm(Qcm $qcm): self
    {
        if ($this->qcm->contains($qcm)) {
            $this->qcm->removeElement($qcm);
            // set the owning side to null (unless already changed)
            if ($qcm->getPack() === $this) {
                $qcm->setPack(null);
            }
        }

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
            $gene->setPack($this);
        }

        return $this;
    }

    public function removeGene(Gene $gene): self
    {
        if ($this->genes->contains($gene)) {
            $this->genes->removeElement($gene);
            // set the owning side to null (unless already changed)
            if ($gene->getPack() === $this) {
                $gene->setPack(null);
            }
        }

        return $this;
    }
}
