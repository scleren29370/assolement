<?php

namespace App\Entity;

use App\Repository\AssolementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssolementRepository::class)]
class Assolement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assolements')]
    private ?Parcelle $parcelle = null;

    #[ORM\ManyToOne(inversedBy: 'assolements')]
    private ?Culture $culture = null;

    #[ORM\ManyToOne(inversedBy: 'assolements')]
    private ?Campagne $campagne = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateSemis = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateRecolte = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $tonnage = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $surface = null;

    #[ORM\OneToMany(mappedBy: 'assolement', targetEntity: Traitement::class, cascade: ['persist', 'remove'])]
    private Collection $traitements;

    public function __construct()
    {
        $this->traitements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParcelle(): ?Parcelle
    {
        return $this->parcelle;
    }

    public function setParcelle(?Parcelle $parcelle): self
    {
        $this->parcelle = $parcelle;
        return $this;
    }

    public function getCulture(): ?Culture
    {
        return $this->culture;
    }

    public function setCulture(?Culture $culture): self
    {
        $this->culture = $culture;
        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): self
    {
        $this->campagne = $campagne;
        return $this;
    }

    public function getDateSemis(): ?\DateTimeInterface
    {
        return $this->dateSemis;
    }

    public function setDateSemis(?\DateTimeInterface $dateSemis): self
    {
        $this->dateSemis = $dateSemis;
        return $this;
    }

    public function getDateRecolte(): ?\DateTimeInterface
    {
        return $this->dateRecolte;
    }

    public function setDateRecolte(?\DateTimeInterface $dateRecolte): self
    {
        $this->dateRecolte = $dateRecolte;
        return $this;
    }

    public function getTonnage(): ?float
    {
        return $this->tonnage;
    }

    public function setTonnage(?float $tonnage): self
    {
        $this->tonnage = $tonnage;
        return $this;
    }

    public function getSurface(): ?float
    {
        return $this->surface;
    }

    public function setSurface(?float $surface): self
    {
        $this->surface = $surface;
        return $this;
    }

    public function getRendement(): ?float
{
    if (!$this->tonnage || !$this->surface || $this->surface == 0) {
        return null;
    }

    return round($this->tonnage / $this->surface, 2);
}

public function setRendement(): static
{
    if ($this->tonnage && $this->surface && $this->surface > 0) {
        $this->rendement = round($this->tonnage / $this->surface, 2);
    } else {
        $this->rendement = null;
    }

    return $this;
}



    

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(Traitement $traitement): self
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements->add($traitement);
            $traitement->setAssolement($this);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): self
    {
        if ($this->traitements->removeElement($traitement)) {
            if ($traitement->getAssolement() === $this) {
                $traitement->setAssolement(null);
            }
        }

        return $this;
    }

    /**
     * Coût total des traitements pour cet assolement
     */
    public function getCoutTotal(): float
    {
        $total = 0;

        foreach ($this->traitements as $t) {
            $cout = $t->getCoutTraitement();
            if ($cout) {
                $total += $cout;
            }
        }

        return round($total, 2);
    }

    /**
     * Coût par hectare
     */
    public function getCoutHa(): ?float
    {
        if (!$this->surface || $this->surface == 0) {
            return null;
        }

        return round($this->getCoutTotal() / $this->surface, 2);
    }

    /**
     * Coût par tonne
     */
    public function getCoutTonne(): ?float
    {
        if (!$this->tonnage || $this->tonnage == 0) {
            return null;
        }

        return round($this->getCoutTotal() / $this->tonnage, 2);
    }
}
