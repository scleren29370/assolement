<?php

namespace App\Repository;

use App\Entity\Assolement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AssolementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Assolement::class);
    }

    public function sumSurfaceByCulture(int $campagneId): array
    {
        return $this->createQueryBuilder('a')
            ->select('c.nom AS culture, SUM(p.surface) AS total')
            ->join('a.culture', 'c')
            ->join('a.parcelle', 'p')
            ->join('a.campagne', 'ca')
            ->where('ca.id = :campagneId')
            ->setParameter('campagneId', $campagneId)
            ->groupBy('c.nom')
            ->orderBy('total', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByCampagne(int $campagneId): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.campagne', 'ca')
            ->where('ca.id = :campagneId')
            ->setParameter('campagneId', $campagneId)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findNonLivres(int $annee): array
{
    return $this->createQueryBuilder('a')
        ->join('a.campagne', 'c')
        ->where('c.annee = :annee')
        ->andWhere('a.id NOT IN (
            SELECT ass2.id
            FROM App\Entity\Livraison l2
            JOIN l2.assolements ass2
        )')
        ->setParameter('annee', $annee)
        ->getQuery()
        ->getResult();
}


}
