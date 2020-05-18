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

    /**
     * @return Pdi[] Returns an array of pdis which 'ordre' field equals @param order
     */
    public function findByOrder($order, $tournee){
        return $this->createQueryBuilder('p')
            ->where('p.ordre = :ordre AND p.tournee_id = :tournee')
            ->setParameter('ordre', $order)
            ->setParameter('tournee', $tournee)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Pdi Retourne le pdis dont l'ordre est le plus grand dans la tournée (Le dernier pdi de la tournée)
     */
    public function findTopOrder($tournee){
        return $this->getEntityManager()
            ->createQuery('SELECT p 
                            FROM App\Entity\Pdi p 
                            WHERE p.tournee_id = :tournee 
                            ORDER BY p.ordre DESC')
            ->setParameter('tournee', $tournee)
            ->setMaxResults(1)->getOneOrNullResult();
    }

    /**
     * Sort la liste des pdis dont l'ordre est supérieur à celui donné en paramètre et trié en décroissant
     * @return Pdi[] Une liste de pdi triés dans l'ordre décroissant d'ordre dont l'ordre est supérieur au paramètre donné
     */
    public function findAllOrderGreaterThanDesc(int $index, $tournee){
        return $this->createQueryBuilder('p')
            ->where('p.ordre >= :ordre AND p.tournee_id = :tournee')
            ->orderBy('p.ordre', 'DESC')
            ->setParameter('ordre', $index)
            ->setParameter('tournee', $tournee)
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
