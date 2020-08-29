<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    // /**
    //  * @return Note[] Returns an array of Note objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findOneByRecordAndAuthor($recordId,$authorId): ?Note
    {
        $res = $this->createQueryBuilder('n')
            ->andWhere('n.author = :author')
            ->setParameter('author', $authorId)
            ->andWhere('n.record = :record')
            ->setParameter('record', $recordId)
            ->getQuery()
            ->getOneOrNullResult()
        ;



        // dd($res);
        return $res;
    }
    public function findOneByAuthor($authorId): array
    {
        $res = $this->createQueryBuilder('n')
            ->andWhere('n.author = :author')
            ->setParameter('author', $authorId)
            ->getQuery()
            ->getResult()
        ;

        return $res;
    }

    public function findOneByRecord($recordId): ?Note
    {
        $res = $this->createQueryBuilder('n')
            ->andWhere('n.record = :record')
            ->setParameter('record', $recordId)
            ->getQuery()
            ->getOneOrNullResult()
        ;

        return $res;
    }
    
    public function findAllByRecord($recordId): array
    {
        $res = $this->createQueryBuilder('n')
            ->andWhere('n.record = :record')
            ->setParameter('record', $recordId)
            ->getQuery()
            ->getResult()
        ;

        return $res;
    }
}
