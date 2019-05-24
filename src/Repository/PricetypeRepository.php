<?php

namespace App\Repository;

use App\Entity\Pricetype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pricetype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricetype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricetype[]    findAll()
 * @method Pricetype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricetypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pricetype::class);
    }

    // /**
    //  * @return Pricetype[] Returns an array of Pricetype objects
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
    public function findOneBySomeField($value): ?Pricetype
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
