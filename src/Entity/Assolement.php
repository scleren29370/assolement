<?php

namespace App\Entity;

use App\Repository\AssolementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssolementRepository::class)]
class Assolement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Parcelle $parcelle = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Culture $culture = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateSemis = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateRecolte = null;

  #[ORM\ManyToOne]
#[ORM\JoinColumn(nullable: false)]
private ?Campagne $campagne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParcelle(): ?Parcelle
    {
        return $this->parcelle;
    }

    public function setParcelle(?Parcelle $parcelle): static
    {
        $this->parcelle = $parcelle;
        return $this;
    }

    public function getCulture(): ?Culture
    {
        return $this->culture;
    }

    public function setCulture(?Culture $culture): static
    {
        $this->culture = $culture;
        return $this;
    }

    public function getDateSemis(): ?\DateTimeInterface
    {
        return $this->dateSemis;
    }

    public function setDateSemis(\DateTimeInterface $dateSemis): static
    {
        $this->dateSemis = $dateSemis;
        return $this;
    }

    public function getDateRecolte(): ?\DateTimeInterface
    {
        return $this->dateRecolte;
    }

    public function setDateRecolte(?\DateTimeInterface $dateRecolte): static
    {
        $this->dateRecolte = $dateRecolte;
        return $this;
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
}
