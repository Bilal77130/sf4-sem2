<?php

namespace App\Repository;

use App\Entity\ProfilController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfilController|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilController|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilController[]    findAll()
 * @method ProfilController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilController::class);
    }

    // /**
    //  * @return ProfilController[] Returns an array of ProfilController objects
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
    public function findOneBySomeField($value): ?ProfilController
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
