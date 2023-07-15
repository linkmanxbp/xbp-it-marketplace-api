<?php

namespace App\Repository;

use App\Entity\ResponseUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResponseUser>
 *
 * @method ResponseUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResponseUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResponseUser[]    findAll()
 * @method ResponseUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResponseUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResponseUser::class);
    }

//    /**
//     * @return ResponseUser[] Returns an array of ResponseUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResponseUser
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
