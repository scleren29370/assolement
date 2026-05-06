<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // 🔥 Relation ManyToMany vers Assolement
    #[ORM\ManyToMany(targetEntity: Assolement::class)]
    #[ORM\JoinTable(name: 'livraison_assolement')]
    private Collection $assolements;

    #[ORM\ManyToOne]
    private ?Campagne $campagne = null;

    #[ORM\Column(type: 'float')]
    private ?float $quantiteTotale = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateLivraison = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $acheteur = null;

    public function __construct()
    {
        $this->assolements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): static
    {
        $this->campagne = $campagne;
        return $this;
    }

    public function getQuantiteTotale(): ?float
    {
        return $this->quantiteTotale;
    }

    public function setQuantiteTotale(float $quantiteTotale): static
    {
        $this->quantiteTotale = $quantiteTotale;
        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $dateLivraison): static
    {
        $this->dateLivraison = $dateLivraison;
        return $this;
    }

    public function getAcheteur(): ?string
    {
        return $this->acheteur;
    }

    public function setAcheteur(?string $acheteur): static
    {
        $this->acheteur = $acheteur;
        return $this;
    }

    /**
     * @return Collection<int, Assolement>
     */
    public function getAssolements(): Collection
    {
        return $this->assolements;
    }

    public function addAssolement(Assolement $assolement): static
    {
        if (!$this->assolements->contains($assolement)) {
            $this->assolements->add($assolement);
        }
        return $this;
    }

    public function removeAssolement(Assolement $assolement): static
    {
        $this->assolements->removeElement($assolement);
        return $this;
    }

    #[ORM\ManyToOne]
private ?Culture $culture = null;

public function getCulture(): ?Culture
{
    return $this->culture;
}

public function setCulture(?Culture $culture): static
{
    $this->culture = $culture;
    return $this;
}

}
