<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
class Traitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'traitements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Assolement $assolement = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

   
    #[ORM\Column(type: 'float')]
    private ?float $dose = null;

    #[ORM\Column(length: 20)]
    private ?string $unite = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateTraitement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssolement(): ?Assolement
    {
        return $this->assolement;
    }

    public function setAssolement(?Assolement $assolement): self
    {
        $this->assolement = $assolement;
        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;
        return $this;
    }



    public function getDose(): ?float
    {
        return $this->dose;
    }

    public function setDose(float $dose): self
    {
        $this->dose = $dose;
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

    public function getDateTraitement(): ?\DateTimeInterface
    {
        return $this->dateTraitement;
    }

    public function setDateTraitement(\DateTimeInterface $dateTraitement): self
    {
        $this->dateTraitement = $dateTraitement;
        return $this;
    }

    /**
     * Prix unitaire réel basé sur les achats de la campagne
     */
    public function getPrixUnitaireEffectif(): ?float
    {
        if (!$this->produit || !$this->assolement) {
            return null;
        }

        $campagne = $this->assolement->getCampagne();

        return $this->produit->getPrixMoyenCampagne($campagne);
    }

    /**
     * Coût total du traitement pour la parcelle
     */
    public function getCoutTraitement(): ?float
    {
        $prix = $this->getPrixUnitaireEffectif();
        $surface = $this->assolement?->getSurface();

        if (!$prix || !$this->dose || !$surface) {
            return null;
        }

        return round($prix * $this->dose * $surface, 2);
    }

    #[ORM\Column(type: 'text', nullable: true)]
private ?string $commentaire = null;

public function getCommentaire(): ?string
{
    return $this->commentaire;
}

public function setCommentaire(?string $commentaire): self
{
    $this->commentaire = $commentaire;
    return $this;
}
}