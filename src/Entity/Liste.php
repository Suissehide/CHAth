<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListeRepository")
 */
class Liste
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Erreur", mappedBy="liste")
     */
    private $erreurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant", inversedBy="listes")
     */
    private $participant;

    public function __construct()
    {
        $this->erreurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $erreur->setListe($this);
        }

        return $this;
    }

    public function removeErreur(Erreur $erreur): self
    {
        if ($this->erreurs->contains($erreur)) {
            $this->erreurs->removeElement($erreur);
            // set the owning side to null (unless already changed)
            if ($erreur->getListe() === $this) {
                $erreur->setListe(null);
            }
        }

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }
}
