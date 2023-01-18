<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $modele;

    /**
     * @ORM\Column(type="float")
     */
    private $tarifJournalier;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $nbPlace;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $typeMoteur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDispo;

    /**
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="voiture", orphanRemoval=true)
     */
    private $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getTarifJournalier(): ?float
    {
        return $this->tarifJournalier;
    }

    public function setTarifJournalier(float $tarifJournalier): self
    {
        $this->tarifJournalier = $tarifJournalier;

        return $this;
    }

    public function getNbPlace(): ?string
    {
        return $this->nbPlace;
    }

    public function setNbPlace(string $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(string $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getTypeMoteur(): ?string
    {
        return $this->typeMoteur;
    }

    public function setTypeMoteur(string $typeMoteur): self
    {
        $this->typeMoteur = $typeMoteur;

        return $this;
    }

    public function isIsDispo(): ?bool
    {
        return $this->isDispo;
    }

    public function setIsDispo(bool $isDispo): self
    {
        $this->isDispo = $isDispo;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }
}
