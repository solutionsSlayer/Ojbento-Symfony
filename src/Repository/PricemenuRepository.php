<?php

namespace App\Repository;

use App\Entity\Pricemenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pricemenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricemenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricemenu[]    findAll()
 * @method Pricemenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricemenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pricemenu::class);
    }

    // /**
    //  * @return Pricemenu[] Returns an array of Pricemenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pricemenu
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
