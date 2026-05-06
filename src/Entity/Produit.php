<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null; // herbicide, engrais, semence, etc.

    #[ORM\Column(length: 20)]
    private ?string $unite = null; // L, kg, U...

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: AchatProduit::class, cascade: ['persist', 'remove'])]
    private Collection $achats;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Traitement::class)]
    private Collection $traitements;

    public function __construct()
    {
        $this->achats = new ArrayCollection();
        $this->traitements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): self
    {
        $this->unite = $unite;
        return $this;
    }

    /**
     * @return Collection<int, AchatProduit>
     */
    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function addAchat(AchatProduit $achat): self
    {
        if (!$this->achats->contains($achat)) {
            $this->achats->add($achat);
            $achat->setProduit($this);
        }

        return $this;
    }

    public function removeAchat(AchatProduit $achat): self
    {
        if ($this->achats->removeElement($achat)) {
            if ($achat->getProduit() === $this) {
                $achat->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * Prix moyen pondéré pour une campagne
     */
    public function getPrixMoyenCampagne(Campagne $campagne): ?float
    {
        $achats = $this->achats->filter(fn($a) => $a->getCampagne() === $campagne);

        if ($achats->isEmpty()) {
            return null;
        }

        $total = 0;
        $quantiteTotale = 0;

        foreach ($achats as $achat) {
            $total += $achat->getPrixUnitaire() * $achat->getQuantite();
            $quantiteTotale += $achat->getQuantite();
        }

        if ($quantiteTotale == 0) {
            return null;
        }

        return round($total / $quantiteTotale, 2);
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }
}
