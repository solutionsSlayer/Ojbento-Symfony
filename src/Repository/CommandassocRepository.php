<?php

namespace App\Repository;

use App\Entity\Commandassoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commandassoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commandassoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commandassoc[]    findAll()
 * @method Commandassoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandassocRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commandassoc::class);
    }

    // /**
    //  * @return Commandassoc[] Returns an array of Commandassoc objects
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
    public function findOneBySomeField($value): ?Commandassoc
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
