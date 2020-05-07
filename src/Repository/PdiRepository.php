<?php

namespace App\Repository;

use App\Entity\Pdi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pdi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pdi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pdi[]    findAll()
 * @method Pdi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PdiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pdi::class);
    }

    /**
     * @return Pdi[] Returns an Array of Pdis ordered by 'ordre'
     */
    public function findAllByOrder(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.ordre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Pdi[] Returns an array of Pdi objects
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
    public function findOneBySomeField($value): ?Pdi
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
