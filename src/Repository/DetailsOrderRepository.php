<?php

namespace App\Repository;

use App\Entity\DetailsOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetailsOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsOrder[]    findAll()
 * @method DetailsOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsOrder::class);
    }

    // /**
    //  * @return DetailsOrder[] Returns an array of DetailsOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetailsOrder
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
