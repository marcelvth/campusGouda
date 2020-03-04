<?php

namespace App\Repository;

use App\Entity\CgUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CgUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CgUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CgUser[]    findAll()
 * @method CgUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CgUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CgUser::class);
    }

    // /**
    //  * @return CgUser[] Returns an array of CgUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CgUser
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
