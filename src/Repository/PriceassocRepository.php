<?php

namespace App\Repository;

use App\Entity\Priceassoc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Priceassoc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Priceassoc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Priceassoc[]    findAll()
 * @method Priceassoc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceassocRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Priceassoc::class);
    }

    // /**
    //  * @return Priceassoc[] Returns an array of Priceassoc objects
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
    public function findOneBySomeField($value): ?Priceassoc
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
