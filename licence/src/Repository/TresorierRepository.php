<?php

namespace App\Repository;

use App\Entity\Tresorier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tresorier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tresorier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tresorier[]    findAll()
 * @method Tresorier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TresorierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tresorier::class);
    }

    // /**
    //  * @return Tresorier[] Returns an array of Tresorier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tresorier
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
