<?php

namespace App\Repository;

use App\Entity\Beoordeling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Beoordeling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beoordeling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beoordeling[]    findAll()
 * @method Beoordeling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeoordelingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Beoordeling::class);
    }

    // /**
    //  * @return Beoordeling[] Returns an array of Beoordeling objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Beoordeling
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
