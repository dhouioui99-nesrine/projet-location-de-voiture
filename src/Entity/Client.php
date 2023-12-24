<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cin = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Location::class)]
    private Collection $loc_client;

    public function __construct()
    {
        $this->loc_client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): static
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocClient(): Collection
    {
        return $this->loc_client;
    }

    public function addLocClient(Location $locClient): static
    {
        if (!$this->loc_client->contains($locClient)) {
            $this->loc_client->add($locClient);
            $locClient->setClient($this);
        }

        return $this;
    }

    public function removeLocClient(Location $locClient): static
    {
        if ($this->loc_client->removeElement($locClient)) {
            // set the owning side to null (unless already changed)
            if ($locClient->getClient() === $this) {
                $locClient->setClient(null);
            }
        }

        return $this;
    }
}
