<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class AdRepository extends ServiceEntityRepository
{
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