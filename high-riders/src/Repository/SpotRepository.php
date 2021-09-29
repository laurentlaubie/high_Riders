<?php

namespace App\Repository;

use App\Entity\Spot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Spot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spot[]    findAll()
 * @method Spot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spot::class);
    }

    /**
     * Effectue une recherche de séries en fonction de la variable
     * $title
     * 
     * Version 1 : Query builder
     *
     * @param $title
     * @return Spot[]
     */
    public function searchSpotByTitle($title)
    {
        // https://www.doctrine-project.org/projects/doctrine-orm/en/2.9/reference/query-builder.html
        return $this->createQueryBuilder('spot')
            // Clause WHERE pour filtre en fonction de $title
            ->where('spot.title LIKE :title')
            ->setParameter(':title', "%$title%")
            ->orderBy('spot.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Spot[] Returns an array of Spot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Spot
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
