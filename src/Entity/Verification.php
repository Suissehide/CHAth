<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"advancement"})
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement"})
     * @ORM\JoinTable(name="verification_qcm_inclusion",
     *      joinColumns={@ORM\JoinColumn(name="inclusion_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $inclusion;

    /**
     * @ORM\ManyToMany(targetEntity=Qcm::class, cascade={"persist"})
     * @Groups({"advancement"})
     * @ORM\JoinTable(name="verification_qcm_non_inclusion",
     *      joinColumns={@ORM\JoinColumn(name="non_inclusion_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="qcm_id", referencedColumnName="id", onDelete="CASCADE", unique=true)}
     *      )
     */
    private $nonInclusion;

    public function __construct()
    {
        $this->inclusion = new ArrayCollection();
        $this->nonInclusion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeInclusion(Qcm $inclusion): self
    {
        if ($this->inclusion->contains($inclusion)) {
            $this->inclusion->removeElement($inclusion);
        }

        return $this;
    }

    /**
     * @return Collection|Qcm[]
     */
    public function getNonInclusion(): Collection
    {
        return $this->nonInclusion;
    }

    public function addNonInclusion(Qcm $nonInclusion): self
    {
        if (!$this->nonInclusion->contains($nonInclusion)) {
            $this->nonInclusion[] = $nonInclusion;
        }

        return $this;
    }

    public function removeNonInclusion(Qcm $nonInclusion): self
    {
        if ($this->nonInclusion->contains($nonInclusion)) {
            $this->nonInclusion->removeElement($nonInclusion);
        }

        return $this;
    }
}
