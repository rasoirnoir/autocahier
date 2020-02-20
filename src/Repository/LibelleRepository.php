<?php

namespace App\Repository;

use App\Entity\Libelle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Libelle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Libelle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Libelle[]    findAll()
 * @method Libelle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibelleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Libelle::class);
    }

    // /**
    //  * @return Libelle[] Returns an array of Libelle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Libelle
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
