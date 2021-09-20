<?php

namespace App\Repository;

use App\Entity\Contactus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Contactus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contactus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contactus[]    findAll()
 * @method Contactus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contactus::class);
    }

    // /**
    //  * @return Contactus[] Returns an array of Contactus objects
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
    public function findOneBySomeField($value): ?Contactus
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
