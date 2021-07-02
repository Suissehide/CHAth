<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantRepository")
 */
class Participant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"export"})
     */
    private $code;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="participants")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Verification", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $verification;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\General", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $general;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Cardiovasculaire", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $cardiovasculaire;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Information", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $information;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Donnee", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $donnee;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Suivi", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $suivi;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Deces", cascade={"persist", "remove"})
     * @Groups({"advancement", "export"})
     */
    private $deces;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Erreur", mappedBy="participant", cascade={"remove"})
     */
    private $erreurs;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"export"})
     */
    private $validation;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->erreurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
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

        return $this;
    }

    public function getGeneral(): ?General
    {
        return $this->general;
    }

    public function setGeneral(?General $general): self
    {
        $this->general = $general;

        return $this;
    }

    public function getCardiovasculaire(): ?Cardiovasculaire
    {
        return $this->cardiovasculaire;
    }

    public function setCardiovasculaire(?Cardiovasculaire $cardiovasculaire): self
    {
        $this->cardiovasculaire = $cardiovasculaire;

        return $this;
    }

    public function getInformation(): ?Information
    {
        return $this->information;
    }

    public function setInformation(?Information $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getSuivi(): ?Suivi
    {
        return $this->suivi;
    }

    public function setSuivi(?Suivi $suivi): self
    {
        $this->suivi = $suivi;

        return $this;
    }

    public function getDeces(): ?Deces
    {
        return $this->deces;
    }

    public function setDeces(?Deces $deces): self
    {
        $this->deces = $deces;

        return $this;
    }

    public function getDonnee(): ?Donnee
    {
        return $this->donnee;
    }

    public function setDonnee(?Donnee $donnee): self
    {
        $this->donnee = $donnee;

        return $this;
    }

    /**
     * @return Collection|Erreur[]
     */
    public function getErreurs(): Collection
    {
        return $this->erreurs;
    }

    public function addErreur(Erreur $erreur): self
    {
        if (!$this->erreurs->contains($erreur)) {
            $this->erreurs[] = $erreur;
            $erreur->setParticipant($this);
        }

        return $this;
    }

    public function removeErreur(Erreur $erreur): self
    {
        if ($this->erreurs->contains($erreur)) {
            $this->erreurs->removeElement($erreur);
            // set the owning side to null (unless already changed)
            if ($erreur->getParticipant() === $this) {
                $erreur->setParticipant(null);
            }
        }

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(?bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }
}
