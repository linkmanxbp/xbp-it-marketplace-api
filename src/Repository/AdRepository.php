<?php

namespace App\Repository;

use App\Entity\Ad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass = Ad::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function findEasy(string $query): array
    {
        return $this->createQueryBuilder('ad')
            ->orWhere('ad.title LIKE :query')
            ->orWhere('ad.description LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();
    }
}