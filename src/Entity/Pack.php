<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Qcm", mappedBy="pack", cascade={"persist"})
     */
    private $qcm;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Verification", mappedBy="inclusion", cascade={"persist", "remove"})
     */
    private $verification;

    public function __construct()
    {
        $this->qcm = new ArrayCollection();
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

    public function getVerification(): ?Verification
    {
        return $this->verification;
    }

    public function setVerification(?Verification $verification): self
    {
        $this->verification = $verification;

        // set (or unset) the owning side of the relation if necessary
        $newInclusion = $verification === null ? null : $this;
        if ($newInclusion !== $verification->getInclusion()) {
            $verification->setInclusion($newInclusion);
        }

        return $this;
    }
}
